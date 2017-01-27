
/*
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
    
    
.run(function($rootScope, JoinUiService) {
        $rootScope.join = function() {
            JoinUiService.open();
        }
});

*/




/***
Community Post service to manage posts. The $resource object lets us interact with RESTful server-side
data resources.The returned $resource object has action methods which provide high-level behaviors without the need to interact with the low level $http service.
*/
kapp.factory("CommunityPost", function($resource) {
    return $resource(ksm_settings.rest.api_base+"community/posts/:action/:id", {}, {
        query: { method: "POST"},
        remove: {method: "POST"},
        add : {method : "POST", params : {action : '@action'}},
        delete : {method: "POST", params : {id : '@id', action : '@action'}},
        save: {method: "POST", params : {id : '@id', action : '@action'}},
    });
});




/*
	creating the kSPostsController - Controller for posts	
*/

kapp.controller('kSPostsController', ["$scope", "CommunityPost", function($scope, CommunityPost) {

	//Properties of kSPostsController
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
    
    
	/*
		Methods
	*/
	
	//The load method allows posts to be loaded together with paging information
    $scope.load = function(params, pch) {
        $scope.loading = true;
        CommunityPost.query(params, function(r) {
            $scope.kposts = r.posts;
            $scope.paging = r.paging;
            /*
            if(pch) {
                $('html, body').animate({
                    scrollTop: $(".posts").offset().top - 40
                }, 450)
            }
            */
            $scope.loading = false;
        });
    };
    
	//The clearSelection method allows a user to Remove their filter selections
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
    

	//The pageChanged method checks when the page has changed and sets the current page
    $scope.pageChanged = function() {
        $scope.fData.page = $scope.paging.currentPage;
    };
    
    
	//The post_reload method reloads a post in the view
    $scope.post_reload = function() {
        CommunityPost.query(function(r) {
            $scope.kposts = r.posts;
            $scope.paging = r.paging;
        });
    };
    
    $scope.npdata = {
        title : '',
        content : '',
        images : {}
    };
    
    //The edit_post method allow a post to be edited
    $scope.edit_post = function() {
        
    }
    
    //The post_options method display post's options
    $scope.post_options = function(form) {
        
        
    }
    
    
}]);



//Directive to diplay post items 
kapp.directive('kSPost', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"community/post_item/main.html",
        controller : "PostCtrl"
    }
});


//Another controller - to manage post images and commments
kapp.controller("PostCtrl", ["$scope", "Comment", "ReportUI", function($scope, Comment, ReportUI) {
    
	//Properties of PostCtrl - controller
	$scope.show_comments = false; 
    $scope.newCommentData = {
        id : $scope.kpost.post_id,
        action : 'add',
        content : ""
    };
    $scope.show_more = false;
    $scope.gallery_active = false;
	
	
	/*
		Methods
	*/
	
	// show_gallery method - displays post image gallery
    $scope.show_gallery = function() {
        $scope.gallery_active = true;
    };
	
	// hide_gallery method - hides post image gallery
    $scope.hide_gallery = function() {
        $scope.gallery_active = false;
    };

    
    
    $scope.report = function() {
        ReportUI.open($scope.kpost.post_id);
    };
    
    
    
	// saveComment method - saves posts comments and increases count of comments added
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

//Directive to display image
kapp.directive('kSPostImage', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"community/post_item/image.html",
        link : function() {},
        controller : function() {}
    };
});

//Directive to display comments
kapp.directive('kSPostComment', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"community/post_item/comment_item.html",
        link : function($scope) {},
        controller : "CommentCtrl"
    };
});



//Directive to display add comment form
kapp.directive('kSPostAddComment', function() {
    return {
        restrict : 'A',
        templateUrl:ksm_settings.rest.partials+"community/post_item/add_comment.html",

    };
});




////////////////////////////////////////////////////////////////////////////////////////////////


/*
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

*/