var kapp = angular.module('kapp', [
                            'ngResource',
                            'ngAnimate',
                            'ngMessages',
                            'ui.bootstrap',
                            //'k.components.confirm',
                            'k.components.kui',
                            'infinite-scroll',
                            'k.components.comment',
                            'k.util',
                            'k.like',
                            'k.report',
                            'k.user',
                            'k.validation',
                            'k.components.join'
                            ])

.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.common['KSM-Access-ID'] = ksm_settings.rest.access_key;
    $httpProvider.defaults.headers.common['X-WP-NONCE'] = ksm_settings.rest.nonce;

}])


.run(function($rootScope, AuthUiService, JoinUiService, ForgotPasswordUiService, LoginUiService) {

    $rootScope.auth = function(view) {
        console.log('Auth clicked');
        AuthUiService.open(view);
    }

    $rootScope.kpartial = function(name) {
        return ksm_settings.ksm_url+"partials/"+name;
    }
});


(function(angular) {
    function Post($resource) {
        return $resource(ksm_settings.rest.api_base+"posts/:action/:id", {}, {
            query: { method: "POST"},
            remove: {method: "POST"},
            add : {method : "POST", params : {action : '@action'}},
            report : {method: "POST", params : {id : '@id', action : '@action'}},
            save: {method: "POST", params : {id : '@id', action : '@action'}},
        });
    }

    angular.module('k.post', []).
            factory('Post', Post),
            Post.$inject = ["$resource"];

}(angular));



(function (angular) {

    function userService($resource) {

        return $resource(ksm_settings.rest.api_base+"user/:action", {}, {
            register : {method: "POST", params : {action: 'register'}},
            login : {method: "POST", params : {action: 'login'}},
            recover : {method: "POST", params : {action: 'recover'}},
            displayNameAvailable : {method: "POST"}
        });

    }

    angular.module('k.user', []).
            factory('userService', userService),
            userService.$inject = ["$resource"];

}(angular));



(function(angular){


    function ReportUI($modal) {
        return {
            open: function(item) {
                return $modal.open({
                    templateUrl:ksm_settings.ksm_url+"partials/post_report.html",
                    backdrop: "static",
                    size: "lg",
                    controller: "PostReportCtrl as vm",
                    windowClass : 'window post_report',
                    resolve: {
                        item: function() {
                            return item;
                        }
                    }
                });
            }
        };
    }



    function PostReportCtrl($scope, $uibModalInstance, item, Post, InfoBoxUi) {

        var vm = this;

        vm.data = {
            id : item,
            reasons : [],
            action : 'report'
        };


        vm.report = function (form) {
            if(vm.processing) {
                return;
            }
            form.$setSubmitted();
            if(form.$valid) {
                vm.processing = true;
                $scope.error = '';
                Post.report(vm.data, function(r) {
                    if(r.error) {
                        angular.forEach(r.errors, function(v, k) {
                            $scope.error = v;
                        });
                    } else if(r.success) {

                        $uibModalInstance.dismiss();
                        InfoBoxUi.open('', {'message' : 'Thanks for reporting'}, false);
                    }
                    vm.processing = false;
                });
            }
        };

        /*
        vm.report = function (form) {
            form.$setSubmitted();
            if(form.$valid) {

                Post.report(vm.data, function(r) {
                    if(r.success) {
                        return $uibModalInstance.submit(r);
                    } else {
                        console.log(r.data);
                    }
                })
            }
        };
        */



        vm.hasError = function(field, validation){
            return (($scope.reportPostForm.$submitted || $scope.reportPostForm[field].$dirty) && $scope.reportPostForm[field].$invalid);
        };



        /////////////////////////////


        //var vm = this;



        $scope.reasons = [
            {id : '1', state : false , name : 'Threatening or hateful'},
            {id : '2', state : false , name : 'Sexually explicit'},
            {id : '3', state : false , name : 'Violition of copyright'},
            {id : '4', state : false , name : 'Spam or irrelevant'},
            {id : '5', state : false , name : 'Impersonation or stolen identity'},
            {id : '6', state : false , name : 'Excessively derogatory'},
            {id : '7', state : false , name : 'Profanity'}

        ];




    }



    angular.module('k.report', ["k.post"]).run()
           .factory('ReportUI', ReportUI)
           .controller('PostReportCtrl', PostReportCtrl),

    ReportUI.$inject = ["$uibModal"],
    PostReportCtrl.$inject = ["$scope", "$uibModalInstance", "item", "Post", "InfoBoxUi"];




}(angular));


(function(angular) {
    "use strict";




    function Comment($resource) {
        return $resource(ksm_settings.rest.api_base+"comments/:action/:id", {}, {
            query: { method: "POST"},
            remove: {method: "POST"},
            add : {method : "POST", params : {action : '@action'}},
            delete : {method: "POST", params : {id : '@id', action : '@action'}},
            save: {method: "POST", params : {id : '@id', action : '@action'}}
        });
    }


    function CommentCtrl($scope, CommentEditUiService, ConfirmBoxUiService, Comment) {

        $scope.editComment = function() {
            var item = this;


            var ecwin = CommentEditUiService.open($scope.kcomnt);

            ecwin.submit_result.then(function (r) {

                item.kcomnt.content = r.content;
                item.kcomnt.date = r.date;
                item.kcomnt.edited = r.edited;
                ecwin.dismiss("close");
            });
        }


        $scope.deleteComment = function() {
            var item = this;
            var cbwin = ConfirmBoxUiService.open({
                title : "Confirm",
                message : "Are you sure you would like to delete this post?"
            });

            cbwin.submit_result.then(function () {
                Comment.delete({id: $scope.kcomnt.comment_id , action: 'delete'}, function(r) {
                    if(r.success) {
                        item.$parent.kpost.comments_count = parseInt(item.$parent.kpost.comments_count) - 1;
                        var idx = item.$parent.kpost.comments.indexOf(item.kcomnt);
                        item.$parent.kpost.comments.splice(idx, 1);
                    }
                    cbwin.dismiss("close");
                });
            });
        };

    }







    function CommentEditUiService($modal) {
        return {
            open: function(item) {
                return $modal.open({
                    templateUrl:ksm_settings.ksm_url+"partials/comment_edit.html",
                    backdrop: "static",
                    size: "lg",
                    controller: "CommentEditCtrl as vm",
                    windowClass : 'window edit_comment',
                    resolve: {
                        item: function() {
                            return item;
                        }
                    }
                });
            }
        };
    }



    function CommentEditCtrl($scope, $uibModalInstance, item, Comment) {
        var vm = this;

        vm.kc = {
            content : item.content,
            id : item.comment_id,
            action : 'update'
        };
        vm.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };
        vm.save = function (form) {
            form.$setSubmitted();
            if(form.$valid) {
                Comment.save(vm.kc, function(r) {
                    if(r.success) {
                        return $uibModalInstance.submit(r);
                    } else {

                    }
                })
            }
        };


        vm.hasError = function(field, validation){
            return (($scope.editCommentForm.$submitted || $scope.editCommentForm[field].$dirty) && $scope.editCommentForm[field].$invalid);
        };
    }




   angular.module("k.components.comment", [])
          .factory("Comment", Comment)
          .controller("CommentCtrl", CommentCtrl)
          .factory("CommentEditUiService", CommentEditUiService)
          .controller("CommentEditCtrl", CommentEditCtrl),


    Comment.$inject = ["$resource"],
    CommentCtrl.$inject = ["$scope", "CommentEditUiService" , "ConfirmBoxUiService", "Comment"],
    CommentEditUiService.$inject = ["$uibModal"],
    CommentEditCtrl.$inject = ["$scope", "$uibModalInstance", "item", "Comment"];

}(angular));




(function() {
    "use strict";

    function kLike($http) {

        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };

        return {
            restrict : 'A',
            template : '<span class="kng button"></span><span class="count">{{like.count}}</span>',
            scope: { like:'='},

            link : function(scope, ele, attrs) {
                ele.find('.button').on('click', function(e) {
                    if(ele.hasClass('loading')) {
                        return;
                    }
                    ele.addClass('loading');
                    $http.post(ksm_settings.rest.api_base+'like', $.param(scope.like.params), config).then(function(r){
                        scope.like = r.data;
                        ele.removeClass('loading');
                    })
                });

            },


        }

    }





    angular.module('k.like', [])
        .directive('kLike', kLike),
        kLike.$inject = ["$http"]


}(angular));








(function() {


    function list_model() {

        return {
            scope: {
                list: '=kListModel',
                value: '@'
            },

            link: function(scope, elem, attrs) {

                var handler = function(setup) {
                    var checked = elem.prop('checked');
                    var index = scope.list.indexOf(scope.value);

                    if (checked && index == -1) {
                        if (setup) elem.prop('checked', false);
                        else scope.list.push(scope.value);
                    } else if (!checked && index != -1) {
                        if (setup) elem.prop('checked', true);
                        else scope.list.splice(index, 1);
                    }
                };

                var setupHandler = handler.bind(null, true);
                var changeHandler = handler.bind(null, false);

                elem.on('change', function() {
                    scope.$apply(changeHandler);
                });
                scope.$watch('list', setupHandler, true);
            }
        }
    }





    function iCheck($timeout) {

        return {
            restrict: 'A',
            require: 'ngModel',
            scope: {
                model: '=ngModel'
            },
            link: function (scope, element, attrs, ngModel) {
                $timeout(function() {
                    $(element).iCheck({
                      checkboxClass: attrs.icheck,
                      radioClass: attrs.icheck
                    })
                    .on('ifChanged', onChanged);

                    update(ngModel.$modelValue);
                });

                var watchModel = scope.$watch(function() {
                    return ngModel.$modelValue;
                }, update);

                scope.$on('$destroy', function() {
                  watchModel();
                });
                function update(value) {
                  if(attrs.type == 'checkbox') {
                    $(element).iCheck('update');
                  }
                }

                function onChanged(event) {
                    if(attrs.type == 'checkbox') {
                        console.log(event.target.checked);
                        console.log(event.target.value);
                        ngModel.$setViewValue(event.target.checked);
                    }

                    if(attrs.type == 'radio') {
                        ngModel.$setViewValue(event.target.value);
                    }
                }

            }
        };
  }






  function iCheckCollection($timeout) {

        return {
            restrict: 'A',
            require: 'ngModel',
            scope: {
                icheckClass : '@',
                model: '=ngModel',
                collection : '=icheckCollection'
            },
            link: function (scope, element, attrs, ngModel) {
                $timeout(function() {
                    $(element).iCheck({
                      checkboxClass: scope.icheckClass,
                      radioClass: scope.icheckClass
                    })
                    .on('ifChanged', onChanged);

                    update(ngModel.$modelValue);
                });

                var watchModel = scope.$watch(function() {
                    return ngModel.$modelValue;
                }, update);

                scope.$on('$destroy', function() {
                  watchModel();
                });
                function update(value) {
                  if(attrs.type == 'checkbox') {
                    $(element).iCheck('update');
                  }
                }

                function onChanged(event) {
                    if(attrs.type == 'checkbox') {


                        var checked = element.prop('checked');
                        var index = scope.collection.indexOf(event.target.value);

                        if (checked && index == -1) {
                            scope.collection.push(event.target.value);
                        } else if (!checked && index != -1) {
                            scope.collection.splice(index, 1);
                        }


                        //scope.collection.push(event.target.value);
                        console.log(scope.collection);
                        ngModel.$setViewValue(event.target.checked);
                    }

                    if(attrs.type == 'radio') {
                        ngModel.$setViewValue(event.target.value);
                    }
                }



            }
        };
  }







  function facetInputModel() {
      return {
          restrict: 'A',
          require: 'ngModel',
          scope: {
                model: '=facetInputModel',
                ngModel :  '='
          },


          link : function(scope, ele, attrs, ngModel) {
              $(ele).on('keypress', function(e) {
                  var keycode = (e.keyCode ? e.keyCode : e.which);
                  if(keycode == 13) {
                      scope.$apply(function (){
                          scope.model = $(ele).val();
                      });
                  }
              });



                /*var facet_q_timer;
                ele.data('last_value', '');
                scope.$watch(function (){
                    return ngModel.$modelValue;
                }, function (v) {
                    var last_val = ele.data('last_value');
                    if (v == '' && v != last_val) {
                        ele.data('last_value', v);
                        clearTimeout(facet_q_timer);
                        facet_q_timer = setTimeout(function(){
                            scope.$apply(function (){
                                scope.model = v;
                            });
                        }, 500);
                    } else {
                        ele.data('last_value', v);
                    }
                }); */
          }

      }
  }



    function slick_gallery($timeout) {

        return {
            restrict: 'A',
            templateUrl :  ksm_settings.rest.partials+"slick-gallery.html",
            scope : {
                gallery : '=slickGallery',
                active : '=galleryActive',
                ngShow: "="
            },
            link : function(scope, element, attrs) {


                var gallery;
                var destroySlick, initializeSlick, isInitialized;




                //var ;



              /*
                scope.$on(
                        "$destroy",
                        function( event ) {
                            console.log(event);
                        }
                    );

                destroy = function() {
                    return $timeout(function() {
                        console.log(gallery);
                        //gallery.params.full_slick.unslick();
                        //gallery.params.nav_slick.unslick();


                        //slider = $(element);
                        //slider.slick('unslick');
                        //slider.find('.slick-list').remove();

                        var full_slider = $(gallery.params.full_element + ' .slider');
                        var nav_slider = $(gallery.params.nav_element + ' .slider');


                        //$($0).slick('unslick')

                        full_slider.slick('unslick');
                        full_slider.find('.slick-list').remove();

                        nav_slider.slick('unslick');
                        nav_slider.find('.slick-list').remove();


                        //$(gallery.params.full_element).slick('unslick');
                        //$(gallery.params.nav_element).slick('unslick');


                        //$(gallery.params.nav_element).find('.slick-list').remove();
                        //$(gallery.params.full_element).find('.slick-list').remove();

                        //return gallery;
                    });
                };

                */

                initializeSlick = function () {
                    return $timeout(function () {
                        isInitialized = true;
                        gallery = new slick_simple_gallery({
                            ele : '#'+attrs.id,
                            navigation : {
                                slidesToShow : 4,
                                centerPadding : '0px',
                            }
                        });

                        $(gallery).on('nav_change', function() {
                            scope.gallery.full_active = true;
                            scope.$apply();
                        });
                    });
                };
                scope.gallery.full_active = false;
                scope.$watch('gallery.full_active', function(value) {
                    if(!isInitialized) {
                        return;
                    }
                    if(value) {
                        console.log(gallery.params.nav_slick);
                        gallery.params.nav_slick.slickSetOption('slidesToShow', 8, true);
                    } else {
                        gallery.params.nav_slick.slickSetOption('slidesToShow', 4, true);
                    }
                })

                if (attrs.hasOwnProperty("ngShow")) {
                    scope.$watch("ngShow", function (value) {
                        if(value && gallery) {
                            $timeout(function() {
                                gallery.params.full_slick.setPosition();
                                gallery.params.nav_slick.setPosition();
                            });
                        }
                    });
                }


                scope.$watch('gallery', function(newVal, oldVal) {
                    //console.log('watch')
                    if(isInitialized) {
                        /*
                        console.log('is.isInitialized');
                        $timeout(function() {
                            return destroy();
                            //initializeSlick();
                        });
                        */
                    } else {
                        initializeSlick();
                    }

                }, true);

            }
        };
    }


     function slick_galleryz($timeout) {

        return {
            restrict: 'A',
            templateUrl :  ksm_settings.rest.partials+"slick-galleryz.html",
            scope : {
                gallery : '=slickGalleryz',
                active : '=galleryActive',
                ngShow: "="
            },
            link : function(scope, element, attrs) {

                var gallery, destroySlick, initializeSlick, isInitialized;

                scope.$on(
                        "$destroy",
                        function( event ) {
                            console.log(event);
                        }
                    );

                destroy = function() {
                    return $timeout(function() {
                        console.log(gallery);
                        //gallery.params.full_slick.unslick();
                        //gallery.params.nav_slick.unslick();


                        //slider = $(element);
                        //slider.slick('unslick');
                        //slider.find('.slick-list').remove();

                        var full_slider = $(gallery.params.full_element + ' .slider');
                        var nav_slider = $(gallery.params.nav_element + ' .slider');


                        //$($0).slick('unslick')

                        full_slider.slick('unslick');
                        full_slider.find('.slick-list').remove();

                        nav_slider.slick('unslick');
                        nav_slider.find('.slick-list').remove();


                        //$(gallery.params.full_element).slick('unslick');
                        //$(gallery.params.nav_element).slick('unslick');


                        //$(gallery.params.nav_element).find('.slick-list').remove();
                        //$(gallery.params.full_element).find('.slick-list').remove();

                        //return gallery;
                    });
                };


                initializeSlick = function () {
                    return $timeout(function () {
                        isInitialized = true;
                        gallery = new slick_simple_gallery({
                            ele : '#'+attrs.id
                        });
                    });
                };

                if (attrs.hasOwnProperty("ngShow")) {
                    scope.$watch("ngShow", function (value) {
                        if(value) {
                            if(gallery) {
                                $timeout(function() {
                                    gallery.params.full_slick.setPosition();
                                    gallery.params.nav_slick.setPosition();
                                })

                            }
                        }
                    });
                }


                scope.$watch('gallery', function(newVal, oldVal) {
                    console.log('watch')
                    if(isInitialized) {
                        console.log('is.isInitialized')
                        $timeout(function() {
                            return destroy();
                            //initializeSlick();
                        });

                    } else {
                        initializeSlick();
                    }

                }, true);
                //initializeSlick();
            }
        }
    }


    function kFormBtn() {
        return {
            restrict: 'A',
            template :  '<span ng-hide="processing" class="form-btn-label">{{btnLabel}}</span><span ng-show="processing" k-button-loading class="form-btn-loading"></span>',
            scope : {
                btnLabel: "@",
                processing : '=kProcessing'
            }
        };
    }


    function kButtonLoading() {
        return {
            restrict: 'A',
            template :  '<span class="edd-loading"><i class="edd-icon-spinner edd-icon-spin"></i></span>'
        };
    }







    function kCharacterLimit() {
        return {
            restrict : 'A',
            scope : {
                limit : '=kCharacterLimit'
            },
            require:'ngModel',
            link : function(scope, ele, attrs, ctrl) {
                var limit = scope.limit;



                ctrl.$parsers.push(function (value) {
                    if (value.length > limit) {
                        value = value.substr(0, limit);
                        ctrl.$setViewValue(value);
                        ctrl.$render();
                    }

                    return value;
                });


                /*
                attrs.$observe('value', function (value) {
                    console.log(value);
                    if (value) {

                        //scope.variable = value;

                        var left = limit - value.length;
                        scope.characters_left = left;
                    }
                });
                */

            }
        }
    }



    function AutoExpand($timeout, $window) {
        return function(scope, element, attr) {

            element.css({overflow : "hidden", wordWrap: 'break-word'});


            var update = function(){
                element.css("height", "auto");
                element.css("height", element[0].scrollHeight + "px");
            };
            scope.$watch(attr.ngModel, function(){
                update();
            });
            attr.$set("ngTrim", "false");
        };
    }



    function PasswordStrength() {
        return {
            restrict : 'A',
            require:'ngModel',
            scope : {
                model: '=ngModel',
                meter : '=kPasswordStrength'
            },
            link : function(scope, ele, attrs, ngModel) {


                var strength,meter ;




                scope.$watch(function () {
                    return ngModel.$$rawModelValue;
                } , function(value) {
                    meter = {strength : 'short', text : pwsL10n.short, show : true};
                    if(value === undefined) {
                        value = "";
                        meter.show = false;
                    }

                    strength = wp.passwordStrength.meter( value, Array());

                    if(strength == 2) meter = {strength : 'bad', text : pwsL10n.bad, show : true};
                    else if(strength == 3) meter = {strength : 'good', text : pwsL10n.good, show : true};
                    else if(strength == 4) meter = {strength : 'strong', text : pwsL10n.strong, show : true};
                    else if(strength == 5) meter = {strength : 'short', text : pwsL10n.mismatch, show : true};

                    scope.meter = meter;
                });




            }
        }
    }

    angular.module('k.util', [])
           .directive('kListModel', list_model)
           .directive('icheck', iCheck)
           .directive('icheckCollection', iCheckCollection)
           .directive('facetInputModel', facetInputModel)
		   .directive('slickGalleryz', slick_galleryz)
           .directive('slickGallery', slick_gallery)
           .directive('kFormBtn', kFormBtn)
           .directive('kButtonLoading', kButtonLoading)
           .directive('kCharacterLimit', kCharacterLimit)
           .directive('kAutoExpand', AutoExpand)
           .directive('kPasswordStrength', PasswordStrength),




    slick_gallery.$inject = ['$timeout'],
	slick_galleryz.$inject = ['$timeout'],
    AutoExpand.$inject = ["$timeout", "$window"],
    iCheck.$inject = ['$timeout'];

}(angular));



(function() {



    function infiniteScroll($rootScope, $window, $interval, THROTTLE_MILLISECONDS) {

        return {
            scope: {
              infiniteScroll: '&',
              infiniteScrollContainer: '=',
              infiniteScrollDistance: '=',
              infiniteScrollDisabled: '=',
              infiniteScrollUseDocumentBottom: '=',
              infiniteScrollListenForEvent: '@'
            },
            link: function(scope, elem, attrs) {
              var changeContainer, checkInterval, checkWhenEnabled, container, handleInfiniteScrollContainer, handleInfiniteScrollDisabled, handleInfiniteScrollDistance, handleInfiniteScrollUseDocumentBottom, handler, height, immediateCheck, offsetTop, pageYOffset, scrollDistance, scrollEnabled, throttle, unregisterEventListener, useDocumentBottom, windowElement;
              windowElement = angular.element($window);
              scrollDistance = null;
              scrollEnabled = null;
              checkWhenEnabled = null;
              container = null;
              immediateCheck = true;
              useDocumentBottom = false;
              unregisterEventListener = null;
              checkInterval = false;
              height = function(elem) {
                elem = elem[0] || elem;
                if (isNaN(elem.offsetHeight)) {
                  return elem.document.documentElement.clientHeight;
                } else {
                  return elem.offsetHeight;
                }
              };
              offsetTop = function(elem) {
                if (!elem[0].getBoundingClientRect || elem.css('none')) {
                  return;
                }
                return elem[0].getBoundingClientRect().top + pageYOffset(elem);
              };
              pageYOffset = function(elem) {
                elem = elem[0] || elem;
                if (isNaN(window.pageYOffset)) {
                  return elem.document.documentElement.scrollTop;
                } else {
                  return elem.ownerDocument.defaultView.pageYOffset;
                }
              };
              handler = function() {
                var containerBottom, containerTopOffset, elementBottom, remaining, shouldScroll;
                if (container === windowElement) {
                  containerBottom = height(container) + pageYOffset(container[0].document.documentElement);
                  elementBottom = offsetTop(elem) + height(elem);
                } else {
                  containerBottom = height(container);
                  containerTopOffset = 0;
                  if (offsetTop(container) !== void 0) {
                    containerTopOffset = offsetTop(container);
                  }
                  elementBottom = offsetTop(elem) - containerTopOffset + height(elem);
                }
                if (useDocumentBottom) {
                  elementBottom = height((elem[0].ownerDocument || elem[0].document).documentElement);
                }
                remaining = elementBottom - containerBottom;
                shouldScroll = remaining <= height(container) * scrollDistance + 1;
                if (shouldScroll) {
                  checkWhenEnabled = true;
                  if (scrollEnabled) {
                    if (scope.$$phase || $rootScope.$$phase) {
                      return scope.infiniteScroll();
                    } else {
                      return scope.$apply(scope.infiniteScroll);
                    }
                  }
                } else {
                  if (checkInterval) {
                    $interval.cancel(checkInterval);
                  }
                  return checkWhenEnabled = false;
                }
              };
              throttle = function(func, wait) {
                var later, previous, timeout;
                timeout = null;
                previous = 0;
                later = function() {
                  previous = new Date().getTime();
                  $interval.cancel(timeout);
                  timeout = null;
                  return func.call();
                };
                return function() {
                  var now, remaining;
                  now = new Date().getTime();
                  remaining = wait - (now - previous);
                  if (remaining <= 0) {
                    $interval.cancel(timeout);
                    timeout = null;
                    previous = now;
                    return func.call();
                  } else {
                    if (!timeout) {
                      return timeout = $interval(later, remaining, 1);
                    }
                  }
                };
              };
              if (THROTTLE_MILLISECONDS != null) {
                handler = throttle(handler, THROTTLE_MILLISECONDS);
              }
              scope.$on('$destroy', function() {
                container.unbind('scroll', handler);
                if (unregisterEventListener != null) {
                  unregisterEventListener();
                  return unregisterEventListener = null;
                }
              });
              handleInfiniteScrollDistance = function(v) {
                return scrollDistance = parseFloat(v) || 0;
              };
              scope.$watch('infiniteScrollDistance', handleInfiniteScrollDistance);
              handleInfiniteScrollDistance(scope.infiniteScrollDistance);
              handleInfiniteScrollDisabled = function(v) {
                scrollEnabled = !v;
                if (scrollEnabled && checkWhenEnabled) {
                  checkWhenEnabled = false;
                  return handler();
                }
              };
              scope.$watch('infiniteScrollDisabled', handleInfiniteScrollDisabled);
              handleInfiniteScrollDisabled(scope.infiniteScrollDisabled);
              handleInfiniteScrollUseDocumentBottom = function(v) {
                return useDocumentBottom = v;
              };
              scope.$watch('infiniteScrollUseDocumentBottom', handleInfiniteScrollUseDocumentBottom);
              handleInfiniteScrollUseDocumentBottom(scope.infiniteScrollUseDocumentBottom);
              changeContainer = function(newContainer) {
                if (container != null) {
                  container.unbind('scroll', handler);
                }
                container = newContainer;
                if (newContainer != null) {
                  return container.bind('scroll', handler);
                }
              };
              changeContainer(windowElement);
              if (scope.infiniteScrollListenForEvent) {
                unregisterEventListener = $rootScope.$on(scope.infiniteScrollListenForEvent, handler);
              }
              handleInfiniteScrollContainer = function(newContainer) {
                if ((newContainer == null) || newContainer.length === 0) {
                  return;
                }
                if (newContainer.nodeType && newContainer.nodeType === 1) {
                  newContainer = angular.element(newContainer);
                } else if (typeof newContainer.append === 'function') {
                  newContainer = angular.element(newContainer[newContainer.length - 1]);
                } else if (typeof newContainer === 'string') {
                  newContainer = angular.element(document.querySelector(newContainer));
                }
                if (newContainer != null) {
                  return changeContainer(newContainer);
                } else {
                  throw new Error("invalid infinite-scroll-container attribute.");
                }
              };
              scope.$watch('infiniteScrollContainer', handleInfiniteScrollContainer);
              handleInfiniteScrollContainer(scope.infiniteScrollContainer || []);
              if (attrs.infiniteScrollParent != null) {
                changeContainer(angular.element(elem.parent()));
              }
              if (attrs.infiniteScrollImmediateCheck != null) {
                immediateCheck = scope.$eval(attrs.infiniteScrollImmediateCheck);
              }
              return checkInterval = $interval((function() {
                if (immediateCheck) {
                  handler();
                }
                return $interval.cancel(checkInterval);
              }));
            }
          };
    }



    angular.module('infinite-scroll' ,  [])
           .directive('infiniteScroll' ,  infiniteScroll)
           .value('THROTTLE_MILLISECONDS', null),

           infiniteScroll.$inject = ["$rootScope", "$window", "$interval", "THROTTLE_MILLISECONDS"];


}(angular));



(function(angular) {


    "use strict";




    function Comment($resource) {
        return $resource(ksm_settings.rest.api_base+"comments/:action/:id", {}, {
            query: { method: "POST"},
            remove: {method: "POST"},
            add : {method : "POST", params : {action : '@action'}},
            delete : {method: "POST", params : {id : '@id', action : '@action'}},
            save: {method: "POST", params : {id : '@id', action : '@action'}}
        });
    }


    function CommentCtrl($scope, CommentEditUiService, ConfirmBoxUiService, Comment) {

        $scope.editComment = function() {
            var item = this;


            var ecwin = CommentEditUiService.open($scope.kcomnt);

            ecwin.submit_result.then(function (r) {

                item.kcomnt.content = r.content;
                item.kcomnt.date = r.date;
                item.kcomnt.edited = r.edited;
                ecwin.dismiss("close");
            });
        }




    }








    function ForgotPasswordUiService($modal) {
        return {
            open: function() {
                return $modal.open({
                    templateUrl:ksm_settings.ksm_url+"partials/forgot_password.html",
                    backdrop: "static",
                    size: "lg",
                    controller: "ForgotPasswordCtrl as vm",
                    windowClass : 'window join'
                });
            }
        };
    }



    function ForgotPasswordCtrl($scope, $uibModalInstance, userService, InfoBoxUi) {
        var vm = this;

        vm.jd = {};
        vm.processing = false;
        $scope.errors = {};

        vm.processForgotPassword = function (form) {
            if(vm.processing) {
                return;
            }
            form.$setSubmitted();
            if(form.$valid) {
                vm.processing = true;
                $scope.errors = {};
                userService.register(vm.jd, function(r) {
                    if(r.error) {
                        angular.forEach(r.errors, function(v, k) {
                            $scope.errors[v.field] = {};
                            $scope.errors[v.field][v.rule] = v.msg;
                        });
                    } else if(r.success) {
                        $uibModalInstance.dismiss();
                        InfoBoxUi.open('join_success', {}, false);
                    }
                    vm.processing = false;
                });
            }
        };
    }




    function LoginUiService($modal) {
        return {
            open: function() {
                return $modal.open({
                    templateUrl:ksm_settings.ksm_url+"partials/login.html",
                    backdrop: "static",
                    size: "lg",
                    controller: "LoginCtrl as vm",
                    windowClass : 'window login'
                });
            }
        };
    }



    function LoginCtrl($scope, $uibModalInstance, userService, InfoBoxUi) {
        var vm = this;

        vm.jd = {};
        vm.processing = false;
        $scope.errors = {};

        vm.processLogin = function (form) {
            if(vm.processing) {
                return;
            }
            form.$setSubmitted();
            if(form.$valid) {
                vm.processing = true;
                $scope.errors = {};
                userService.register(vm.jd, function(r) {
                    if(r.error) {
                        angular.forEach(r.errors, function(v, k) {
                            $scope.errors[v.field] = {};
                            $scope.errors[v.field][v.rule] = v.msg;
                        });
                    } else if(r.success) {
                        $uibModalInstance.dismiss();
                        InfoBoxUi.open('join_success', {}, false);
                    }
                    vm.processing = false;
                });
            }
        };

    }


    function AuthUiService($modal) {
        return {
            open: function(view) {
                return $modal.open({
                    templateUrl:ksm_settings.ksm_url+"partials/auth.html",
                    backdrop: "static",
                    size: "lg",
                    controller: "AuthCtrl as vm",
                    windowClass : 'window join',
                    resolve: {
                        view: function() {
                            return view;
                        }
                    }
                });
            }
        };
    }


    function AuthCtrl($scope, $uibModalInstance, userService, InfoBoxUi, view) {
        var vm = this;

        vm.recaptcha_site_key = ksm_settings.recaptcha_site_key;

        vm.setView = function(view) {
            vm.view = view;
            $scope.errors = {};
            $scope.error = '';
            vm.processing = false;
            vm.jd = {};
            vm.ld = {};
            vm.rd = {};
            $scope.success = false;
            $scope.success_msg = '';
        }

        if(view) {
            vm.setView(view);
        }


        $scope.form_action = ksm_settings.ajax_url;



        vm.processRecover = function (form) {
            if(vm.processing) {
                return;
            }
            form.$setSubmitted();
            if(form.$valid) {
                vm.processing = true;
                $scope.errors = {};
                userService.recover(vm.rd, function(r) {
                    vm.processing = false;
                    if(r.error) {
                        angular.forEach(r.errors, function(v, k) {
                            $scope.error = v;
                        });
                    }
                    else if(r.success) {
                        $scope.success = true;
                        $scope.success_msg = r.msg;
                    }

                });
            }
        };

        vm.processLogin = function (form) {
            if(vm.processing) {
                return;
            }
            form.$setSubmitted();
            if(form.$valid) {
                vm.processing = true;
                $scope.errors = {};
                userService.login(vm.ld, function(r) {
                    vm.processing = false;

                    if(r.error) {
                        angular.forEach(r.errors, function(v, k) {
                            $scope.error = v;
                        });
                    }
                    else if(r.success) {
                        $uibModalInstance.dismiss();
                        window.location = r.redirect;
                    }

                });
            }
        };


        vm.processJoin = function (form) {
            if(vm.processing) {
                //return;
            }
            form.$setSubmitted();
            if(form.$valid) {
                vm.processing = true;
                $scope.errors = {};
                vm.jd.recaptcha_response = grecaptcha.getResponse();
                userService.register(vm.jd, function(r) {
                    if(r.error) {
                        angular.forEach(r.errors, function(v, k) {
                            $scope.errors[v.field] = {};
                            $scope.errors[v.field][v.rule] = v.msg;
                        });

                        if($scope.errors.recaptcha_response) {
                            grecaptcha.reset();
                        }
                    } else if(r.success) {
                        $uibModalInstance.dismiss();
                        InfoBoxUi.open('join_success', {}, false);
                    }
                    vm.processing = false;
                });
            }
        };



    }


    function JoinUiService($modal) {
        return {
            open: function() {
                return $modal.open({
                    templateUrl:ksm_settings.ksm_url+"partials/join.html",
                    backdrop: "static",
                    size: "lg",
                    controller: "JoinCtrl as vm",
                    windowClass : 'window join'
                });
            }
        };
    }



    function JoinCtrl($scope, $uibModalInstance, userService, InfoBoxUi) {
        var vm = this;

        vm.jd = {};
        vm.processing = false;
        $scope.errors = {};




        vm.processJoin = function (form) {
            if(vm.processing) {
                return;
            }
            form.$setSubmitted();
            if(form.$valid) {
                vm.processing = true;
                $scope.errors = {};
                userService.register(vm.jd, function(r) {
                    if(r.error) {
                        angular.forEach(r.errors, function(v, k) {
                            $scope.errors[v.field] = {};
                            $scope.errors[v.field][v.rule] = v.msg;
                        });
                    } else if(r.success) {
                        $uibModalInstance.dismiss();
                        InfoBoxUi.open('join_success', {}, false);
                    }
                    vm.processing = false;
                });
            }
        };

    }




   angular.module("k.components.join", [])
          //.factory("Comment", Comment)
          .controller("JoinCtrl", JoinCtrl)
          .factory("JoinUiService", JoinUiService)

          .controller("LoginCtrl", LoginCtrl)
          .factory("LoginUiService", LoginUiService)

          .controller("AuthCtrl", AuthCtrl)
          .factory("AuthUiService", AuthUiService)

          .controller("ForgotPasswordCtrl", ForgotPasswordCtrl)
          .factory("ForgotPasswordUiService", ForgotPasswordUiService),


          //.controller("CommentEditCtrl", CommentEditCtrl),


    //Comment.$inject = ["$resource"],
    JoinUiService.$inject = ["$uibModal"],
    JoinCtrl.$inject = ["$scope", "$uibModalInstance", "userService", "InfoBoxUi"],

    LoginUiService.$inject = ["$uibModal"],
    LoginCtrl.$inject = ["$scope", "$uibModalInstance", "userService", "InfoBoxUi"],

    AuthUiService.$inject = ["$uibModal"],
    AuthCtrl.$inject = ["$scope", "$uibModalInstance", "userService", "InfoBoxUi", "view"],

    ForgotPasswordUiService.$inject = ["$uibModal"],
    ForgotPasswordCtrl.$inject = ["$scope", "$uibModalInstance", "userService", "InfoBoxUi"];





}(angular));





(function(angular) {

    function kValidateBetweenLength() {
        return {
            restrict: "A",

            require: 'ngModel',
            scope: {
                kValidateBetweenLength: '=betweenLength'
            },

            link : function(scope, ele, attrs, ctrl) {
                ctrl.$validators.betweenLength = function (modelValue, viewValue) {

                    if(typeof viewValue == "undefined") {
                        return false;
                    }

                    var length_param = angular.fromJson(attrs.kValidateBetweenLength);
                    var min = parseInt(length_param.min);
                    var max = parseInt(length_param.max);
                    var length = parseInt(viewValue.length);

                    if (length >= min && length <= max) {
                        return true;
                    }
                    else return false;
                };
            }
        }
    }



    function kValidateAlphaNumSpace() {
        return {
            restrict: "A",

            require: 'ngModel',


            link : function(scope, ele, attrs, ctrl) {
                ctrl.$validators.alphaNumSpace = function (modelValue, viewValue) {

                    if(typeof viewValue == "undefined") {
                        return false;
                    }
                    var REGEX = /^[A-Za-z\d\s]+$/;
                    if (REGEX.test(viewValue)) {
                        return true;
                    }
                    return false;
                };
            }
        }
    }


    function kValidateEmail() {
        return {
            restrict: "A",

            require: 'ngModel',


            link : function(scope, ele, attrs, ctrl) {
                ctrl.$validators.email = function (modelValue, viewValue) {

                    if(typeof viewValue == "undefined") {
                        return false;
                    }

                    var REGEX = /^[\w-]+(\.[\w-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*?\.[a-z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{4})?$/i;

                    if (REGEX.test(viewValue)) {
                        return true;
                    }
                    return false;
                };
            }
        }
    }





    function kValidateDisplayNameAvailable($q, userService) {

        return {
            require: 'ngModel',
            link: function (scope, element, attrs, ctrl) {
                ctrl.$asyncValidators.username = function (modelValue, viewValue) {
                    return $q(function (resolve, reject) {
                        userService.displayNameAvailable({name: viewValue, action:'displayNameAvailable'}, function() {
                            resolve();
                        }, function() {
                            reject();
                        });
                    });
                };
            }
        };
    }







    angular.module('k.validation', [])
           .directive('kValidateBetweenLength', kValidateBetweenLength)
           .directive('kValidateAlphaNumSpace', kValidateAlphaNumSpace)
           .directive('kValidateEmail', kValidateEmail)
           .directive('kValidateDisplayNameAvailable', kValidateDisplayNameAvailable),

   kValidateDisplayNameAvailable.$inject = ["$q", "userService"];




}(angular));




(function(angular) {
    "use strict";



    function InfoBoxUi($modal) {
        return {
            open: function(name, info, animation) {
                var _temp = name ? 'info-dialog/'+name : 'info-dialog';

                if (typeof animation === "undefined" || animation === null) {
                    animation = true
                }

                return $modal.open({
                    templateUrl:ksm_settings.ksm_url+"partials/"+ _temp+'.html',
                    backdrop: "static",
                    size: "lg",
                    controller: "InfoBoxCtrl as vm",
                    windowClass : 'window info-dialog '+name,
                    animation : animation,
                    resolve: {
                        info: function() {
                            return info;
                        }
                    }
                });
            },
        };
    }
    function InfoBoxCtrl($scope, $uibModalInstance, info) {
        var vm = this;
        $scope.info = info;
    }




    function ConfirmBoxUiService($modal) {
        return {

            open: function(confirm) {
                return $modal.open({
                    templateUrl:ksm_settings.ksm_url+"partials/confirm.html",
                    backdrop: "static",
                    size: "lg",
                    controller: "ConfirmBoxCtrl as vm",
                    windowClass : 'window confirm',
                    resolve: {
                        confirm: function() {
                            return confirm;
                        }
                    }
                });
            },
        };
    }
    function ConfirmBoxCtrl($uibModalInstance, confirm) {
        var vm = this;
        vm.title = confirm.title;
        vm.message = confirm.message;

        vm.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };

        vm.yes = function() {
            return $uibModalInstance.submit();
        };

        vm.close = function() {
            $uibModalInstance.close('yes');
        }

    }







    angular.module("k.components.kui", ["ui.bootstrap"])
           .controller("InfoBoxCtrl", InfoBoxCtrl)
           .controller("ConfirmBoxCtrl", ConfirmBoxCtrl)
           .factory("ConfirmBoxUiService", ConfirmBoxUiService)
           .factory("InfoBoxUi", InfoBoxUi),
           InfoBoxUi.$inject = ["$uibModal"],
           ConfirmBoxUiService.$inject = ["$uibModal", "$q"],
           InfoBoxCtrl.$inject = ["$scope", "$uibModalInstance", "info"];
           ConfirmBoxCtrl.$inject = ["$uibModalInstance", "confirm", "$q"];


}(angular));