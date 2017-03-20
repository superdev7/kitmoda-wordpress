

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

}]);


kapp.config(function($locationProvider) {
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
});

kapp.run(function($rootScope, JoinUiService) {
        $rootScope.join = function() {
            JoinUiService.open();
        };
    $rootScope.parent_id = [];
    $rootScope.parent_name = [];
});

kapp.controller('page_content', ['$scope','$rootScope','$http','$location', function($scope, $rootScope, $http,$location) {
    var location_search = $location.search();
    $rootScope.show_page_part = (location_search.search == true)?'search':'content';
    $scope.show_page_part = (location_search.search == true)?'search':'content';

    $scope.$watch(function(){ return $location.search() }, function(new_v,old_v){
        if(old_v.search == true && !new_v.search){
            document.location.href = $location.url();
        }
    //     var location_search = $location.search();
    //     $rootScope.show_page_part = (location_search.search == true)?'search':'content';
    //     $scope.show_page_part = (location_search.search == true)?'search':'content';
    });
    $scope.$watch(function(){ return $location.path() }, function(new_v,old_v){
        if(old_v != new_v){
            document.location.href = $location.url();
        }
        //     var location_search = $location.search();
        //     $rootScope.show_page_part = (location_search.search == true)?'search':'content';
        //     $scope.show_page_part = (location_search.search == true)?'search':'content';
    });
    $rootScope.$watch('show_page_part',function (new_v,old_v) {
        // $rootScope.show_page_part = (location_search.search == true)?'search':'content';
        $scope.show_page_part = $rootScope.show_page_part;
    });

    $scope.goto_cat = function (cat,cid,cname,style) {
        if(style){
            $location.search({
            'search': true,
            'style': style
        });
        }else {
            $location.search({
                'search': true,
                'cat': cat,
                'cid': cid,
                'cname': cname
            });
        }
        document.location.href = $location.url();
    };
    $scope.goto_all = function (is_all) {
        if(is_all == 'all'){
            $location.search({
                'search': true,
                'style': 'all'
            });
            document.location.href = $location.url();
        }else {
            $location.search({
                'search': true,
                'cat': 'all'
            });
            document.location.href = $location.url();
        }
    };


    $scope.categories_is_open = 'false';
    $rootScope.categories_is_open = 'false';

    $rootScope.$watch('categories_is_open',function (new_v,old_v) {
        $scope.categories_is_open = $rootScope.categories_is_open;
    });
    jQuery(document).on('click','.refine',function(){
        if($scope.categories_is_open == 'true'){
            $scope.switch_icon();
            $scope.$apply();
        }
    });
    $scope.switch_icon = function () {
        if($scope.categories_is_open == 'false'){
            $scope.categories_is_open = 'true';
            $rootScope.categories_is_open = 'true';
        }else{
            $scope.categories_is_open = 'false';
            $rootScope.categories_is_open = 'false';
        }
    };

}]);

kapp.controller('searchBox', ['$scope','$rootScope','$http','$location', function($scope, $rootScope, $http,$location) {

    /* categories menu  Start */
    $scope.categories_list = null;
    $scope.parent_id = [];
    $scope.parent_name = [];
    $scope.child_categories_list = null;

    var config = {
        headers : {
            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
        }
    };

    $http.post(ksm_settings.rest.api_base+'categories', ctp({ id:'-'}), config).then(function(r){
        $scope.categories_list = r.data;
    });

    $scope.get_child = function (id,name) {
        // $('.subCategory.secondList').slideUp();
        $scope.selected_categorie_name = name;
        $scope.selected_categorie_id = id;
        if(!$scope.parent_id){
            $scope.top_parent_id = id;
        }
        $scope.parent_id[$scope.parent_id.length] = id;
        $scope.parent_name[$scope.parent_name.length] = name;
        $rootScope.parent_id[$scope.parent_id.length] = id;
        $rootScope.parent_name[$scope.parent_name.length] = name;
        $scope.child_categories_list = '';
        $http.post(ksm_settings.rest.api_base+'categories', ctp({ id:id}), config).then(function(r){
            if(get_obj_lent(r.data) > 0) {
                $scope.child_categories_list = r.data;
            }else{
                $location.search({
                    'search':true,
                    'cat':$scope.selected_categorie_id,
                    'cid':btoa(angular.toJson($rootScope.parent_id)),
                    'cname':btoa(angular.toJson($rootScope.parent_name))
                });
                // $('.secondList').slideUp();
                // $('.thirdStep').slideUp();
                document.location.href = $location.url();
            }
        });
    };
    $scope.goto_category = function(){
        // $('.subCategory.secondList').slideUp();
        $location.search({
            'search':true,
            'cat':$scope.selected_categorie_id,
            'cid':btoa(angular.toJson($rootScope.parent_id)),
            'cname':btoa(angular.toJson($rootScope.parent_name))
        });
        $('.thirdStep .back').closest('.thirdStep').removeClass('transformInsideBlock');
        setTimeout(function(){
            $('.thirdStep .back').closest('.thirdStep').removeClass('opened_ctg');
        }, 200); 
        document.location.href = $location.url();
    };

    $scope.go_to_parent = function(){
        $scope.parent_id.pop();
        $scope.parent_name.pop();
        $rootScope.parent_id.pop();
        $rootScope.parent_name.pop(); 
        if($scope.parent_id.length == 0){
            $('.thirdStep .back').closest('.thirdStep').removeClass('transformInsideBlock');
            setTimeout(function(){
                $('.thirdStep .back').closest('.thirdStep').removeClass('opened_ctg');
            }, 200); 

            // $('.subCategory.secondList').slideDown('active');
        }else {
            $http.post(ksm_settings.rest.api_base + 'categories', ctp({id: $scope.parent_id[$scope.parent_id.length - 1]}), config).then(function (r) {
                $scope.selected_categorie_name = $scope.parent_name[$scope.parent_name.length - 1];
                $scope.child_categories_list = r.data;
            });
        }
    };
    /* categories menu  END */

}]);
kapp.controller('searchInput', ['$scope','$rootScope','$http','$location', function($scope, $rootScope, $http,$location) {

    console.log(document.location.href);
    var location_search = $location.search();
    $scope.search_by_text = function () {
        if($scope.search_text == undefined){
            $location.search({
                'search':true
            });
        }else {
            $location.search({
                'search': true,
                'q': btoa($scope.search_text)
            });
        }
        document.location.href = $location.url();
    };
    if(location_search.q){
        $scope.search_text = atob(location_search.q);
    }

}]);


kapp.controller('search', ['$scope','$rootScope','$http','$location', function($scope, $rootScope, $http,$location) {
    var location_search = $location.search();
    $rootScope.show_page_part = (location_search.search == true)?'search':'content';
    $scope.search_text = '';
    if(location_search.cid &&location_search.cid != 'no' && location_search.cname){
        $rootScope.parent_id = JSON.parse(atob(location_search.cid));
        $rootScope.parent_name = JSON.parse(atob(location_search.cname));
        $rootScope.parent_id = $rootScope.parent_id.slice(1,$rootScope.parent_id.length);
        $rootScope.parent_name = $rootScope.parent_name.slice(1,$rootScope.parent_name.length);
        $scope.breadcrumbs = [];
        for(var i = 0; i<$rootScope.parent_id.length; i++){
            $scope.breadcrumbs[i] = [];
            $scope.breadcrumbs[i]['id'] = $rootScope.parent_id[i];
            $scope.breadcrumbs[i]['name'] = $rootScope.parent_name[i];
        }
    }else{
        $scope.breadcrumbs = [];
    }
    $scope.categories_is_open = 'false';
    $rootScope.categories_is_open = 'false';

    $rootScope.$watch('categories_is_open',function (new_v,old_v) {
        $scope.categories_is_open = $rootScope.categories_is_open;
    });
    $scope.switch_icon = function () {
        if($scope.categories_is_open == 'false'){
            $scope.categories_is_open = 'true';
            $rootScope.categories_is_open = 'true';
        }else{
            $scope.categories_is_open = 'false';
            $rootScope.categories_is_open = 'false';
        }
    };

    $scope.change_cat = function(cat_id){
        $location.search({
            'search':true,
            'cat':cat_id,
            'cid':btoa(angular.toJson($rootScope.parent_id)),
            'cname':btoa(angular.toJson($rootScope.parent_name))
        });
        document.location.href = $location.url();
    };
    if(location_search.q){
        $scope.search_text = atob(location_search.q);
    }

    if(location_search.style){
        $scope.style = location_search.style;
    }else {
        $scope.style = 'all';
    }
    $scope.culture = 'all';
    $scope.file_format = 'all';
    $scope.game_ready = [];
    $scope.game_ready['all'] = true;
    $scope.print_ready = [];
    $scope.environment = [];
    $scope.model_constr = [];
    $scope.model_angular = 'all'; //model_constr
    $scope.model_scale = '';
    $scope.texturing_status = 'all';
    $scope.mapping = 'none';
    $scope.lighting = [];
    $scope.lighting['none'] = true;
    $scope.renderer = 'vray';
    $scope.price_min = '';
    $scope.price_max = '';

    $rootScope.$watch('culture',function (new_v,old_v) {
        if(typeof new_v == 'object') {
            if (typeof new_v[0] == 'string') {
                $scope.culture = new_v;
            }
        }
    });
    $rootScope.$watch('style',function (new_v,old_v) {
        if(typeof new_v == 'object') {
            if (typeof new_v[0] == 'string') {
                $scope.style = new_v;
            }
        }
    });


    $scope.filtering = function(){

        $scope.posts = [];
        $scope.game_ready = $scope.clear_arr($scope.game_ready);
        $scope.print_ready = $scope.clear_arr($scope.print_ready);
        $scope.environment = $scope.clear_arr($scope.environment);
//        $scope.model_constr = $scope.clear_arr($scope.model_constr);
//         $scope.texturing_status = $scope.clear_arr($scope.texturing_status);
        $scope.lighting = $scope.clear_arr($scope.lighting);
        // $scope.renderer = $scope.clear_arr($scope.renderer);

        var data = {};

        if($scope.price_min != '' && $scope.price_max != '' &&
            typeof $scope.price_min == 'number' && typeof $scope.price_max == 'number'){

            var price_arr = [
                '5-10',
                '10-25',
                '25-50',
                '50-75',
                '75-100',
                '100-150',
                '150-200',
                '200-300',
                '300-more'
            ];
            var price_arr_calc = [
                [5,10],
                [10,25],
                [25,50],
                [50,75],
                [75,100],
                [100,150],
                [150,200],
                [200,300],
                [300,'more']
            ];

            if($scope.price_min < 300){
                var min_p = 0;
                var max_p = 0;
                for(var i=0; i<price_arr_calc.length; i++){
                    if(price_arr_calc[i][0] <= $scope.price_min && $scope.price_min <= price_arr_calc[i][1]){
                        min_p = i;
                    }
                    if(price_arr_calc[i][0] <= $scope.price_max && $scope.price_max <= price_arr_calc[i][1]){
                        max_p = i;
                    }
                }
                data.price = price_arr.slice(min_p,max_p+1);
            }else{
                data.price = ['300-more'];
            }
        }


        if(get_obj_lent($scope.style) > 0){ data.style = [$scope.style]; }
        if(get_obj_lent($scope.culture) > 0){data.culture = [$scope.culture]; }
        if(get_obj_lent($scope.file_format) > 0){data.file_format = [$scope.file_format]; }
        if(get_obj_lent($scope.game_ready) > 0){data.game_ready = Object.keys($scope.game_ready); }
        if(get_obj_lent($scope.print_ready) > 0){data.print_ready = Object.keys($scope.print_ready); }
        if(get_obj_lent($scope.environment) > 0){data.environment = Object.keys($scope.environment); }
//        if(get_obj_lent($scope.model_constr) > 0){data.model_constr = Object.keys($scope.model_constr); }
        if(get_obj_lent($scope.model_angular) > 0){data.model_angular = [$scope.model_angular] }
        if(get_obj_lent($scope.model_scale) > 0){data.model_scale = [$scope.model_scale]; }
        if(get_obj_lent($scope.texturing_status) > 0){data.texturing_status = [$scope.texturing_status]; }
        if(get_obj_lent($scope.mapping) > 0){data.mapping = [$scope.mapping]; }
        if(get_obj_lent($scope.renderer) > 0){data.renderer = [$scope.renderer]; }
        if(get_obj_lent($scope.lighting) > 0){data.lighting = Object.keys($scope.lighting); }
        if(get_obj_lent($scope.era) > 0){data.era = $scope.era; }
        if(get_obj_lent($scope.poly_count) > 0){data.poly_count = $scope.poly_count; }
        if($scope.search_text != '') {
            data.q = $scope.search_text;
        }
        if(location_search.cat) {
            data.cat = location_search.cat;
        }
        data.action ='Store_filter_posts';
        jQuery.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data:data,
            success: function(res) {
                res = $.parseJSON(res);
                jQuery('.pictures').html(res.posts);
                if( jQuery('.pictures .empty_msg').length == 0 ){
                    setTimeout(function () {
                        jQuery('.pictures').flexImages({rowHeight: 190});

                    },100);
                }                
            }
        });
    };

    $scope.clear_arr = function(arr) {
        for (var key in arr) {
            if (arr[key] == false) {
                delete arr[key];
            }
        }
        return arr;
    };

    // ** Vars eras, erasLength are in search_form.php

    var countRanges = ['0', '500', '2 k', '10 k', '25 k', '100 k', '500 k', '1 m', '5 m', '10 m', '15 m'], // 'poly_count' is other on Datestore (for example: 500-2k)
        countRangesLength = countRanges.length - 1;

    var polygon_tax_back = [
        '10-500',
        '500-2k',
        '2k-10k',
        '10k-25k',
        '25k-100k',
        '100k-500k',
        '500k-1m',
        '1m-5m',
        '5m-10m',
        '10m-15m'
    ];
    jQuery("#slider").slider({
        min: 0,
        max: 4,
        values: [0,4],
        range: true,
        create: function( event, ui ) {
            jQuery(".era-slider .first").text(eras[0]);
            jQuery(".era-slider .second").text(eras[erasLength]);
        }
    }).slider("pips", {
        first: false,
        last: false
    }).on("slidechange", function(e,ui) {
        jQuery(".era-slider .first").text(eras[ui.values[0]]);
        jQuery(".era-slider .second").text(eras[ui.values[1]]);

        $scope.era = eras.slice(ui.values[0],ui.values[1]);
        $scope.filtering();
    });

    jQuery("#polygonCount").slider({
        min: 0,
        max: 10,
        values: [0,10],
        range: true,
        create: function( event, ui ) {
            jQuery(".polygon-count-slider .first").text(countRanges[0]);
            jQuery(".polygon-count-slider .second").text(countRanges[countRangesLength]);
        }
    }).slider("pips", {
        first: false,
        last: false
    }).on("slidechange", function(e,ui) {
        jQuery(".polygon-count-slider .first").text(countRanges[ui.values[0]]);
        jQuery(".polygon-count-slider .second").text(countRanges[ui.values[1]]);

        $scope.poly_count = polygon_tax_back.slice(ui.values[0],ui.values[1]);
        $scope.filtering();
    });


    jQuery("#polygonEra").slider({
        min: 0,
        max: 5,
        values: [0,5],
        range: true,
        create: function( event, ui ) {
            jQuery(".era .first").text(eras[0]);
            jQuery(".era .second").text(eras[erasLength]);
        }
    }).slider("pips", {
        rest: "label",
        labels: eras
    }).on("slidechange", function(e,ui) {
        jQuery(".era .first").text(eras[ui.values[0]]);
        jQuery(".era .second").text(eras[ui.values[1]]);
    });



    if(location_search.search == true)
    $scope.filtering();
}]);

kapp.controller('refineMenu', ['$scope','$rootScope','$http','$location', function($scope, $rootScope, $http,$location) {
    var location_search = $location.search();
    $scope.style = 'all';
    $scope.culture = 'none/general';
    $scope.era = [];
    $scope.environment = [];
    $scope.file_format = [];
    $scope.poly_count = [
        '10-500',
        '500-2k',
        '2k-10k',
        '10k-25k',
        '25k-100k',
        '100k-500k',
        '500k-1m',
        '1m-5m',
        '5m-10m',
        '10m-15m'
    ];
    $scope.pr_rating = 1;
    $scope.price_min = '';
    $scope.price_max = '';


    $scope.filtering_refine = function(){
        jQuery('.refine-menu').hide();
        $('#fadingCover').fadeOut();
        $rootScope.show_page_part = 'search';
        $location.search({
            'search':true
        });
        $scope.file_format = $scope.clear_arr($scope.file_format);

        var data = {};

        if($scope.price_min != '' && $scope.price_max != '' &&
            typeof $scope.price_min == 'number' && typeof $scope.price_max == 'number'){

            var price_arr = [
                '5-10',
                '10-25',
                '25-50',
                '50-75',
                '75-100',
                '100-150',
                '150-200',
                '200-300',
                '300-more'
            ];
            var price_arr_calc = [
                [5,10],
                [10,25],
                [25,50],
                [50,75],
                [75,100],
                [100,150],
                [150,200],
                [200,300],
                [300,'more']
            ];

            if($scope.price_min < 300){
                var min_p = 0;
                var max_p = 0;
                for(var i=0; i<price_arr_calc.length; i++){
                    if(price_arr_calc[i][0] <= $scope.price_min && $scope.price_min <= price_arr_calc[i][1]){
                        min_p = i;
                    }
                    if(price_arr_calc[i][0] <= $scope.price_max && $scope.price_max <= price_arr_calc[i][1]){
                        max_p = i;
                    }
                }
                data.price = price_arr.slice(min_p,max_p+1);
            }else{
                data.price = ['300-more'];
            }
        }
        data.pr_rating = $scope.pr_rating;
        data.style = [$scope.style];
        data.culture = [$scope.culture];
        $rootScope.culture = data.culture;
        $rootScope.style = data.style;
        if($scope.era.length > 0){data.era = $scope.era; }
        if($scope.environment.length > 0){data.environment = $scope.environment; }
        if($scope.poly_count.length > 0){data.poly_count = $scope.poly_count; }
        if(get_obj_lent($scope.file_format) > 0){data.file_format = Object.keys($scope.file_format); }

        if(location_search.cat)
        data.cat = location_search.cat;
        data.action ='Store_filter_posts';
        jQuery.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data:data,
            success: function(res) {
                res = $.parseJSON(res);
                jQuery('.pictures').html(res.posts);
                if( jQuery('.pictures .empty_msg').length == 0 ){
                    setTimeout(function () {
                        jQuery('.pictures').flexImages({rowHeight: 190});

                    },100);
                }
            }
        });
    };

    $scope.clear_arr = function(arr) {
        for (var key in arr) {
            if (arr[key] == false) {
                delete arr[key];
            }
        }
        return arr;
    };

    // ** Vars eras, erasLength are in search_form.php

    var countRanges = ['0', '500', '2 k', '10 k', '25 k', '100 k', '500 k', '1 m', '5 m', '10 m', '15 m'], // 'poly_count' is other on Datestore (for example: 500-2k)
        countRangesLength = countRanges.length - 1;


    var polygon_tax_back = [
        '10-500',
        '500-2k',
        '2k-10k',
        '10k-25k',
        '25k-100k',
        '100k-500k',
        '500k-1m',
        '1m-5m',
        '5m-10m',
        '10m-15m'
    ];



    jQuery("#polygonEra").slider({
        min: 0,
        max: 5,
        values: [0,5],
        range: true,
        create: function( event, ui ) {
            jQuery(".era .first").text(eras[0]);
            jQuery(".era .second").text(eras[erasLength]);
        }
    }).slider("pips", {
        rest: "label",
        labels: eras
    }).on("slidechange", function(e,ui) {
        jQuery(".era .first").text(eras[ui.values[0]]);
        jQuery(".era .second").text(eras[ui.values[1]]);
        $scope.era = eras.slice(ui.values[0],ui.values[1]);
    });

var environment = ['show both', 'single object', 'full environment'];
    $scope.environment = ['show both'];
    var polygonObjInv = ['show both', 'single object', 'full environment'];
    jQuery("#polygonObjInv").slider({
        min: 0,
        max: 2,
        range: false
    }).slider("pips", {
        rest: 'label',
        labels: ['show both', 'single object', 'full environment']
    }).on("slidechange", function(e,ui) {
        $scope.environment = environment[parseInt(ui.value)];
    });

    jQuery("#countRange").slider({
        min: 0,
        max: 10,
        values: [0,10],
        range: true,
        create: function( event, ui ) {
            jQuery(".polCount .first").text(countRanges[0]);
            jQuery(".polCount .second").text(countRanges[countRangesLength]);
        }
    }).slider("pips", {
        rest: 'label',
        labels: countRanges
    }).on("slidechange", function(e,ui) {
        jQuery(".polCount .first").text(countRanges[ui.values[0]]);
        jQuery(".polCount .second").text(countRanges[ui.values[1]]);
        $scope.poly_count = polygon_tax_back.slice(ui.values[0],ui.values[1]);
    });

    $scope.pr_rating = 1;
    jQuery("#productRating").slider({
        min: 0,
        max: 3,
        value: 1,
        range: false
    }).slider("pips", {
        rest: 'label',
        labels: ['&#9733; >', '&#9733;&#9733; >', '&#9733;&#9733;&#9733; >', '&#9733;&#9733;&#9733;&#9733; >']
    }).on("slidechange", function(e,ui) {
        jQuery("#product-rating-number").text(parseInt([ui.value]) + 1);
        $scope.pr_rating = parseInt([ui.value]);
    });

    jQuery("#productRating-sidebar").slider({
        min: 0,
        max: 4,
        value: 1,
        range: true
    }).slider("pips", {
        rest: 'label',
        labels: ['all','&#9733; <span>></span>', '&#9733;&#9733; <span>></span>', '&#9733;&#9733;&#9733; <span>></span>', '&#9733;&#9733;&#9733;&#9733; <span>></span>']
    });

}]);