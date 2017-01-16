
/*
var kapp = angular.module('kapp', [
                            'ngResource',
                            'ngAnimate',
                            'ui.bootstrap',
                            'k.components.confirm', 
                            'k.components.post',
                            'k.components.comment',
                            'k.like',
                            'k.util',
                            'k.report'
                            ])

.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.common['KSM-Access-ID'] = ksm_settings.rest.access_key;
    $httpProvider.defaults.headers.common['X-WP-NONCE'] = ksm_settings.rest.nonce;

}]);


*/




kapp.factory("ksPostService", ["$http", "$q", function($http, $q) {
    var postsBase = ksm_settings.ajax_url;
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        
        return {
            query : function(page) {
                var data = $.param({
                    action : 'Studio_filter_posts',
                    studio : $('#studio_id').val(),
                    page : page
                });
                
                var deferred = $q.defer();
                $http.post(postsBase, data, config).then(function(res){
                    deferred.resolve(res.data);
                }, function() {
                    deferred.reject(res.data);
                });
                return deferred.promise;
            },
            
            get : function () {
                
            },
            update : function() {
                
            },
            remove : function () {
                
            }
        };
}]);

kapp.controller('kSPostsController', ["$scope", "ksPostService", function($scope, ksPostService) {

    $scope.paging =  {};

    $scope.posts = {};


    $scope.pageChanged = function() {
        ksPostService.query($scope.paging.currentPage).then(function(r) {
            $scope.kposts = r.posts;
            $scope.paging = r.paging;
            $('html, body').animate({
                scrollTop: $(".posts").offset().top - 40
            }, 450);
        });
    };
    
    
    $scope.post_reload = function() {
        ksPostService.query().then(function(r) {
            $scope.kposts = r.posts;
            $scope.paging = r.paging;
        });
    };


    $scope.post_reload();

    


    $scope.likeComment = function() {
        var item = this;
        kSPostsFactory.toggleCommentLike(this, function(r) {
            item.kcomnt.likes_count = r.count;
            item.kcomnt.like_action.class = r.class;
            var params = item.kcomnt.like_action.params;
            params.id = r.action;
            item.kcomnt.like_action.params = params;
        });
    }

}]);




kapp.directive('kSPost', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"studio/post_item/main.html",
        controller : "PostCtrl"
    }
});



kapp.controller("PostCtrl", ["$scope", "Comment", "ReportUI" , function($scope, Comment, ReportUI) {
    $scope.show_comments = false;




    $scope.newCommentData = {
        id : $scope.kpost.post_id,
        action : 'add',
        content : ""
    };
    
    
    
    $scope.report = function() {
        ReportUI.open($scope.kpost.post_id);
    };



    $scope.saveComment = function(form) {

        form.$setSubmitted();
        console.log(form);
        if(form.$valid) {
            Comment.add($scope.newCommentData, function(r) {
                if(r.success) {
                    $scope.kpost.comments_count++;
                    $scope.kpost.comments.push(r);
                    $scope.newCommentData.content = "";
                    form.$setPristine();
                    form.$setUntouched();
                } else {

                }
            })
        }
    }


    $scope.hasError = function(field, validation){
        return (($scope.addCommentForm.$submitted || $scope.addCommentForm[field].$dirty) && $scope.addCommentForm[field].$invalid);
    };
}])


kapp.directive('kSPostImage', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"studio/post_item/image.html",
        link : function() {},
        controller : function() {}
    };
});


kapp.directive('kSPostComment', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"studio/post_item/comment_item.html",
        link : function($scope) {},
        controller : "CommentCtrl"
    };
});




kapp.directive('kSPostAddComment', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"studio/post_item/add_comment.html",

    };
});




////////////////////////////////////////////////////////////////////////////////////////////////



(function(angular) {
    "use strict";

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

    angular.module("k.components.confirm", ["ui.bootstrap"])
           .controller("ConfirmBoxCtrl", ConfirmBoxCtrl)
           .factory("ConfirmBoxUiService", ConfirmBoxUiService), 
           ConfirmBoxUiService.$inject = ["$uibModal", "$q"],
           ConfirmBoxCtrl.$inject = ["$uibModalInstance", "confirm", "$q"];
}(angular));