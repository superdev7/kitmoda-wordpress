var kapp = angular.module('kapp', [
                            'ngResource',
                            'ngAnimate',
                            'ui.bootstrap',
                            'k.components.confirm',
                            'infinite-scroll',
                            'k.components.comment',
                            'k.util',
                            'k.like'
                            ])

.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.common['KSM-Access-ID'] = ksm_settings.rest.access_key;
    $httpProvider.defaults.headers.common['X-WP-NONCE'] = ksm_settings.rest.nonce;

}]);







kapp.factory("CommunityPost", function($resource) {
    console.log(ksm_settings.rest.api_base+"community/posts/:action/:id");
    return $resource(ksm_settings.rest.api_base+"community/posts/:action/:id", {}, {
        query: { method: "POST"},
        remove: {method: "POST"},
        add : {method : "POST", params : {action : '@action'}},
        delete : {method: "POST", params : {id : '@id', action : '@action'}},
        save: {method: "POST", params : {id : '@id', action : '@action'}}
    });
});










kapp.controller('kSPostsController', ["$scope", "CommunityPost", function($scope, CommunityPost) {

    $scope.paging =  {};
    $scope.posts = {};
    $scope.fData = {topic : []};
    $scope.loading = false;


    $scope.$watch('fData', function (n, o) {
        //console.log(n, o);
        var nn = angular.copy(n);
        if(n.page == o.page) {
            nn.page = 1;
        }
        var page_changed = n.page != o.page ? false : true;
        $scope.load(nn, page_changed);
    }, true);


    $scope.load = function(params, pch) {
        $scope.loading = true;
        CommunityPost.query(params, function(r) {
            console.log(r);
            $scope.kposts = r.posts;
            $scope.paging = r.paging;
            if(pch) {
                $('html, body').animate({
                    scrollTop: $(".posts").offset().top - 40
                }, 450)
            }
            $scope.loading = false;
        });
    };

    $scope.clearSelection = function() {

        $scope.fData_topic_model = false
        $scope.fData_topic_concept = false
        $scope.fData_topic_challenge = false
        $scope.fData_topic_wip = false
        $scope.fData_topic_finished = false

        $scope.fData_q = '';
        $scope.fData = {topic : []};
    }

    $scope.faset_set_q = function(e) {
         $scope.fData.q = $scope.fData_q;
    }


    $scope.pageChanged = function() {
        $scope.fData.page = $scope.paging.currentPage;
    };


    $scope.post_reload = function() {
        CommunityPost.query(function(r) {
            $scope.kposts = r.posts;
            $scope.paging = r.paging;
        });
    };

}]);




kapp.directive('kSPost', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"community/post_item/main.html",
        controller : "PostCtrl"
    }
});



kapp.controller("PostCtrl", ["$scope", "Comment", function($scope, Comment) {
    $scope.show_comments = false;




    $scope.newCommentData = {
        id : $scope.kpost.post_id,
        action : 'add',
        content : ""
    };


    $scope.show_more = false;

    $scope.gallery_active = false;
    $scope.show_gallery = function() {
        $scope.gallery_active = true;
    };
    $scope.hide_gallery = function() {
        $scope.gallery_active = false;
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
        templateUrl:ksm_settings.rest.partials+"community/post_item/image.html",
        link : function() {},
        controller : function() {}
    };
});


kapp.directive('kSPostComment', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"community/post_item/comment_item.html",
        link : function($scope) {},
        controller : "CommentCtrl"
    };
});




kapp.directive('kSPostAddComment', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"community/post_item/add_comment.html",

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