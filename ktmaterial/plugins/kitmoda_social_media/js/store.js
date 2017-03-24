
function parse_url_search(url) {
    var str = url;
    var search = str.split('?');
    arr = {};

    if(search[1]) {
        search = search[1];
        search = search.split('&');
        for (var i = 0; i < search.length; i++) {
            tmp = search[i].split('=');
            if (tmp[1] == undefined) {
                arr[tmp[0]] = true;
            } else {
                arr[tmp[0]] = decodeURIComponent(tmp[1]);
            }
        }
    }
    return arr;
}
function obj_to_string(str){
    var res='';
    for(var key in str){
        res += key+'='+encodeURIComponent(str[key])+'&';
    }
    return res.slice(0,res.length-1);
}
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

kapp.run(function($rootScope, JoinUiService) {
        $rootScope.join = function() {
            JoinUiService.open();
        };
    $rootScope.parent_id = [];
    $rootScope.parent_name = [];
});

kapp.controller('page_content', ['$scope','$rootScope','$http','$location','$window','$browser',
    function($scope, $rootScope, $http,$location,$window,$browser) {
    var location_search = parse_url_search($location.absUrl());

    $rootScope.show_page_part = (location_search.search == 'true')?'search':'content';
    $scope.show_page_part = (location_search.search == 'true')?'search':'content';

    console.log($scope.show_page_part );
    console.log($rootScope.show_page_part);


    $rootScope.$watch('show_page_part',function (new_v,old_v) {
        $scope.show_page_part = $rootScope.show_page_part;
    });

    $scope.goto_cat = function (cat,cid,cname,style) {
        var search = '';
        if(style){
            search = obj_to_string({
                'search': true,
                'style': style
            });
        }else {
            search = search = obj_to_string({
                'search': true,
                'cat': cat,
                'cid': cid,
                'cname': cname
            });
        }
        window.location = window.location.pathname +'?'+ search;
    };
    $scope.goto_all = function (is_all) {
        var search = '';
        if(is_all == 'all'){
            search = obj_to_string({
                'search': true,
                'style': 'all'
            });
        }else {
            search = obj_to_string({
                'search': true,
                'cat': 'all'
            });
        }
        window.location = window.location.pathname +'?'+ search;
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
                var search = obj_to_string({
                        'search':true,
                        'cat':$scope.selected_categorie_id,
                        'cid':btoa(angular.toJson($rootScope.parent_id)),
                        'cname':btoa(angular.toJson($rootScope.parent_name))
                    });
                // window.location = window.location.pathname +'?'+ search;
                window.location = '/store/' +'?'+ search;
            }
        });
    };
    $scope.goto_category = function(){
        var search = obj_to_string({
            'search':true,
            'cat':$scope.selected_categorie_id,
            'cid':btoa(angular.toJson($rootScope.parent_id)),
            'cname':btoa(angular.toJson($rootScope.parent_name))
        });
        // window.location = window.location.pathname +'?'+ search;
        window.location = '/store/' +'?'+ search;

        $('.thirdStep .back').closest('.thirdStep').removeClass('transformInsideBlock');
        setTimeout(function(){
            $('.thirdStep .back').closest('.thirdStep').removeClass('opened_ctg');
        }, 200);
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

    var location_search = parse_url_search($location.absUrl());
    $scope.search_by_text = function () {
        var search = '';
        if($scope.search_text == undefined){
            search = obj_to_string({
                'search':true
            });
        }else {
            search = obj_to_string({
                'search': true,
                'q': btoa($scope.search_text)
            });
        }
    // window.location = window.location.pathname +'?'+ search;
    window.location = '/store/' +'?'+ search;
    };
    if(location_search.q){
        $scope.search_text = atob(location_search.q);
    }

}]);


kapp.controller('search', ['$scope','$rootScope','$http','$location', function($scope, $rootScope, $http,$location) {


    var countRanges = ['0', '500', '2 k', '10 k', '25 k', '100 k', '500 k', '1 m', '5 m', '10 m', '15 m'], // 'poly_count' is other on Datestore (for example: 500-2k)
        countRangesLength = countRanges.length - 1;

    var location_search = parse_url_search($location.absUrl());
    console.log(location_search);
    $rootScope.show_page_part = (location_search.search == 'true')?'search':'content';
    $scope.search_text = '';
    if(location_search.cid &&location_search.cid != 'no' && location_search.cname){
        $rootScope.parent_id = JSON.parse(atob(location_search.cid));
        $rootScope.parent_name = JSON.parse(atob(location_search.cname));
        if($rootScope.parent_id[0] == null) {
            $rootScope.parent_id = $rootScope.parent_id.slice(1, $rootScope.parent_id.length);
            $rootScope.parent_name = $rootScope.parent_name.slice(1, $rootScope.parent_name.length);
        }
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
        for(var i=0; i<$rootScope.parent_id.length;i++){
            $rootScope.parent_id.pop();
            $rootScope.parent_name.pop();
            if(parseInt($rootScope.parent_id[$rootScope.parent_id.length-1]) == parseInt(cat_id)){
                break;
            }
        }

        var search = obj_to_string({
            'search':true,
            'cat':cat_id,
            'cid':btoa(angular.toJson($rootScope.parent_id)),
            'cname':btoa(angular.toJson($rootScope.parent_name))
        });
    window.location = window.location.pathname +'?'+ search;
    };
    if(location_search.q){
        $scope.search_text = atob(location_search.q);
    }

    if(location_search.style){
        $scope.style = location_search.style;
    }else {
        $scope.style = 'all';
    }

    if(location_search.culture){
        if(location_search.culture == 'none/general') {
            $scope.culture = 'all';
        }else {
            $scope.culture = location_search.culture;
        }
    }else {
        $scope.culture = 'all';
    }

    if(location_search.file_format){
        $scope.file_format = location_search.file_format;
    }else {
        $scope.file_format = 'all';
    }

    if(location_search.era){
        $scope.era_range = angular.fromJson(location_search.era);
        $scope.era_range[1] = $scope.era_range[1];
        $scope.era = eras.slice($scope.era_range[0],($scope.era_range[1]+1));
    }else{
        $scope.era = [];
    }
    if(location_search.poly_count){
        $scope.poly_count_range = angular.fromJson(location_search.poly_count);
        $scope.poly_count_range[1] = $scope.poly_count_range[1]+1;
        $scope.poly_count = countRanges.slice($scope.poly_count_range[0],$scope.poly_count_range[1]);
    }else{
        $scope.poly_count = [];
    }



    $scope.game_ready = [];
    // $scope.game_ready['all'] = true;
    $scope.print_ready = [];
    $scope.environment = [];
    $scope.model_constr = [];
    $scope.model_angular = 'all'; //model_constr
    $scope.model_scale = '';
    // $scope.texturing_status = 'all';
    $scope.texturing_status = false;
    // $scope.mapping = 'none';
    $scope.lighting = [];
    // $scope.lighting['none'] = true;
    // $scope.renderer = 'vray';
    $scope.renderer = false;


    if(location_search.price){
        $scope.price_range = angular.fromJson(location_search.price);
        $scope.price_max = $scope.price_range[1];
        $scope.price_min = $scope.price_range[0];
    }else{
        $scope.price_max = '';
        $scope.price_min = '';
    }

    if(location_search.pr_rating){
        $scope.pr_rating = parseInt(location_search.pr_rating);
    }else {
        $scope.pr_rating = 0;
    }

    $rootScope.$watch('culture',function (new_v,old_v) {
        if(typeof new_v == 'object') {
            if (typeof new_v[0] == 'string') {
                if(new_v == 'none/general') {
                    $scope.culture = 'all';
                }else {
                    $scope.culture = new_v[0];
                }
            }

        }
    });
    $rootScope.$watch('style',function (new_v,old_v) {
        if(typeof new_v == 'object') {
            if (typeof new_v[0] == 'string') {
                $scope.style = new_v[0];
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

        $scope.price_min = parseInt($scope.price_min);
        $scope.price_max = parseInt($scope.price_max);

        if(!isNaN($scope.price_min) && !isNaN($scope.price_max) && typeof $scope.price_min == 'number' && typeof $scope.price_max == 'number'){

            console.log($scope.price_min);
            console.log($scope.price_max);

//            var price_arr = [
//                '5-10',
//                '10-25',
//                '25-50',
//                '50-75',
//                '75-100',
//                '100-150',
//                '150-200',
//                '200-300',
//                '300-more'
//            ];
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

            if($scope.price_min < 300 && $scope.price_max){
                var min_p = 0;
                var max_p = 0;
                for(var i=0; i<price_arr_calc.length; i++){
                    if(price_arr_calc[i][0] <= $scope.price_min && $scope.price_min <= price_arr_calc[i][1]){
                        min_p = i;
                    }
                    if(price_arr_calc[i][0] < $scope.price_max && $scope.price_max <= price_arr_calc[i][1]){
                        max_p = i;
                    }
                }
                console.log(min_p);
                console.log(max_p);
                if(max_p == 0 && parseInt($scope.price_max) > 300){
                    data.price = price_arr.slice(min_p, price_arr_calc.length);
                }else {
                    data.price = price_arr.slice(min_p, max_p + 1);
                }
            }else{
                data.price = ['300-more'];
            }
        }else{
            if($scope.price_min >= 300 && !isNaN($scope.price_min) && typeof $scope.price_min == 'number'){
                data.price = ['300-more'];
            }
        }


        data.pr_rating = $scope.pr_rating;
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


        var tmp_click_go = localStorage.getItem('click_go');
        if(tmp_click_go == 'yes') {
            data.era = $scope.era;
            data.environment = angular.fromJson(localStorage.getItem('environment'));
            localStorage.setItem('click_go', 'no');
        }else {
            if (get_obj_lent($scope.era) > 0) {
                data.era = $scope.era;
            }
        }

        console.log(tmp_click_go);
        console.log(data);
        if(get_obj_lent($scope.poly_count) > 0){data.poly_count = $scope.poly_count; }
        if($scope.search_text != '') {
            data.q = $scope.search_text;
        }
        if(location_search.cat && location_search.cat != '') {
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

    // ** Vars eras, erasLength, polygon_tax_back, price_arr are in search_form.php


//    var polygon_tax_back = [
//        '10-500',
//        '500-2k',
//        '2k-10k',
//        '10k-25k',
//        '25k-100k',
//        '100k-500k',
//        '500k-1m',
//        '1m-5m',
//        '5m-10m',
//        '10m-15m'
//    ];
    jQuery("#slider").slider({
        min: 0,
        max: 5,
        values: ($scope.era_range && $scope.era_range[1])? [$scope.era_range[0],$scope.era_range[1]]: [0,5],
        range: true,
        create: function( event, ui ) {
            if($scope.era_range) {
                jQuery(".era-slider .first").text(eras[($scope.era_range[0]) ? $scope.era_range[0] : 0]);
                jQuery(".era-slider .second").text(eras[($scope.era_range[1]) ? $scope.era_range[1]: erasLength]);
            }else{
                jQuery(".era-slider .first").text(eras[0]);
                jQuery(".era-slider .second").text(eras[erasLength]);
            }
        }
    }).slider("pips", {
        first: false,
        last: false
    }).on("slidechange", function(e,ui) {
        jQuery(".era-slider .first").text(eras[ui.values[0]]);
        jQuery(".era-slider .second").text(eras[ui.values[1]]);

        $scope.era = eras.slice(ui.values[0],(ui.values[1]+1));
        // console.log(eras);
        // console.log(ui.values[0]);
        // console.log(ui.values[1]);
        $scope.filtering();
    });

    jQuery("#polygonCount").slider({
        min: 0,
        max: 10,
        values: ($scope.poly_count_range && $scope.poly_count_range[1])? [$scope.poly_count_range[0],($scope.poly_count_range[1]-1)] : [0,10],
        range: true,
        slide: function(event, ui) { return (ui.values[1] - ui.values[0] > 0); },
        create: function( event, ui ) {
            console.log($scope.poly_count_range);
            if($scope.poly_count_range) {
                jQuery(".polygon-count-slider .first").text(countRanges[($scope.poly_count_range[0]) ? $scope.poly_count_range[0] : 0]);
                jQuery(".polygon-count-slider .second").text(countRanges[($scope.poly_count_range[1]) ? ($scope.poly_count_range[1]-1) : countRangesLength]);
            }else{
                jQuery(".polygon-count-slider .first").text(countRanges[0]);
                jQuery(".polygon-count-slider .second").text(countRanges[countRangesLength]);
            }
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


    // jQuery("#polygonEra").slider({
    //     min: 0,
    //     max: 5,
    //     values: [0,5],
    //     range: true,
    //     create: function( event, ui ) {
    //         jQuery(".era .first").text(eras[0]);
    //         jQuery(".era .second").text(eras[erasLength]);
    //     }
    // }).slider("pips", {
    //     rest: "label",
    //     labels: eras
    // }).on("slidechange", function(e,ui) {
    //     jQuery(".era .first").text(eras[ui.values[0]]);
    //     jQuery(".era .second").text(eras[ui.values[1]]);
    // });

    jQuery("#productRating-sidebar").slider({
        min: 0,
        max: 4,
        value: $scope.pr_rating,
        range: false,
        create: function( event, ui ) {
            jQuery("#product-rating-number").text(parseInt($scope.pr_rating));
        }
    }).slider("pips", {
        rest: 'label',
        labels: ['all','&#9733; <span>></span>', '&#9733;&#9733; <span>></span>', '&#9733;&#9733;&#9733; <span>></span>', '&#9733;&#9733;&#9733;&#9733; <span>></span>']
    }).on("slidechange", function(e,ui) {
        jQuery("#product-rating-number").text(parseInt([ui.value]) + 1);
        $scope.pr_rating = parseInt([ui.value]);
        $scope.filtering();
    });



    // jQuery("#productRating").slider({
    //     min: 0,
    //     max: 3,
    //     value: $scope.pr_rating-1,
    //     range: false,
    //     create: function( event, ui ) {
    //         jQuery("#product-rating-number").text(parseInt($scope.pr_rating));
    //     }
    // }).slider("pips", {
    //     rest: 'label',
    //     labels: ['&#9733; >', '&#9733;&#9733; >', '&#9733;&#9733;&#9733; >', '&#9733;&#9733;&#9733;&#9733; >']
    // }).on("slidechange", function(e,ui) {
    //     jQuery("#product-rating-number").text(parseInt(parseInt([ui.value]) + 1));
    //     $scope.pr_rating = parseInt(parseInt([ui.value])+1);
    // });






    if(location_search.search == 'true')
    $scope.filtering();
}]);

kapp.controller('refineMenu', ['$scope','$rootScope','$http','$location', function($scope, $rootScope, $http,$location) {
    var location_search = parse_url_search($location.absUrl());
    console.log(location_search );

    if(location_search.style){
        $scope.style = location_search.style;
    }else {
        $scope.style = 'all';
    }
    if(location_search.culture){
        if(location_search.culture == 'all') {
            $scope.culture = 'none/general';
        }else {
            $scope.culture = location_search.culture;
        }
    }else {
        $scope.culture = 'none/general';
    }
    if(location_search.era){
        $scope.era_range = angular.fromJson(location_search.era);
        $scope.era_range[1] = $scope.era_range[1];
        $scope.era = '['+$scope.era_range[0]+','+$scope.era_range[1]+']';
    }else{
        $scope.era = '[0,6]';
    }
    if(location_search.poly_count){
        $scope.poly_count_range = angular.fromJson(location_search.poly_count);
        $scope.poly_count_range[1] = $scope.poly_count_range[1];
        $scope.poly_count = '['+$scope.poly_count_range[0]+','+$scope.poly_count_range[1]+']';
    }else{
        $scope.poly_count = '[0,10]';
    }
    if(location_search.file_format){
        $scope.file_format = location_search.file_format;
    }else {
        $scope.file_format = '';
    }
    if(location_search.pr_rating){
        $scope.pr_rating = parseInt(location_search.pr_rating);
    }else {
        $scope.pr_rating = 0;
    }
    if(location_search.environment){
        $scope.environment = location_search.environment;
    }else {
        $scope.environment = 0;
    }
    if(location_search.price){
        $scope.price_range = angular.fromJson(location_search.price);
        $scope.price_max = $scope.price_range[1];
        $scope.price_min = $scope.price_range[0];
    }else{
        $scope.price_max = '';
        $scope.price_min = '';
    }


    $scope.filtering_refine = function(){
        jQuery('.refine-menu').hide();
        $('#fadingCover').fadeOut();
        $rootScope.show_page_part = 'search';

        var location_search = parse_url_search($location.absUrl());

        var data = {};
        data.search = 'true';
        $scope.price_min = parseInt($scope.price_min);
        $scope.price_max = parseInt($scope.price_max);

        if(!isNaN($scope.price_min) && !isNaN($scope.price_max) && typeof $scope.price_min == 'number' && typeof $scope.price_max == 'number'){
            data.price = '['+$scope.price_min+','+$scope.price_max+']';
        }
        data.pr_rating = $scope.pr_rating;
        data.style = [$scope.style];
        data.culture = [$scope.culture];
        $rootScope.culture = data.culture;
        $rootScope.style = data.style;
        data.era = $scope.era;
        data.environment = $scope.environment;
        data.poly_count = $scope.poly_count;

        var environment = ['show both', 'single object', 'full environment'];
        localStorage.setItem('environment', angular.toJson(environment[data.environment]));
        localStorage.setItem('era', angular.toJson(eras.slice($scope.era[0],$scope.era[1])));
        localStorage.setItem('click_go', 'yes');


        if(get_obj_lent($scope.file_format) > 0){data.file_format = [$scope.file_format]; }

        if(location_search.cat && location_search.cat != '')
        data.cat = location_search.cat;

        var search = obj_to_string(data);

        // window.location = window.location.pathname +'?'+ search;
        window.location = '/store/' +'?'+ search;
    };

    $scope.clear_arr = function(arr) {
        for (var key in arr) {
            if (arr[key] == false) {
                delete arr[key];
            }
        }
        return arr;
    };

    // ** Vars eras, erasLength, polygon_tax_back, price_arr are in search_form.php

    var countRanges = ['0', '500', '2 k', '10 k', '25 k', '100 k', '500 k', '1 m', '5 m', '10 m', '15 m'], // 'poly_count' is other on Datestore (for example: 500-2k)
        countRangesLength = countRanges.length - 1;


//    var polygon_tax_back = [
//        '10-500',
//        '500-2k',
//        '2k-10k',
//        '10k-25k',
//        '25k-100k',
//        '100k-500k',
//        '500k-1m',
//        '1m-5m',
//        '5m-10m',
//        '10m-15m'
//    ];



    jQuery("#polygonEra").slider({
        min: 0,
        max: 5,
        values: ($scope.era_range && $scope.era_range[1])? [$scope.era_range[0],$scope.era_range[1]]: [0,5],
        range: true,
        create: function( event, ui ) {
            if($scope.era_range) {
                jQuery(".era .first").text(eras[($scope.era_range[0]) ? $scope.era_range[0] : 0]);
                jQuery(".era .second").text(eras[($scope.era_range[1]) ? $scope.era_range[1]: erasLength]);
            }else{
                jQuery(".era .first").text(eras[0]);
                jQuery(".era .second").text(eras[erasLength]);
            }
        }
    }).slider("pips", {
        rest: "label",
        labels: eras
    }).on("slidechange", function(e,ui) {
        jQuery(".era .first").text(eras[ui.values[0]]);
        jQuery(".era .second").text(eras[ui.values[1]]);
        $scope.era = '['+ui.values[0]+','+parseInt(parseInt(ui.values[1]))+']';
        console.log($scope.era);
    });



var environment = ['show both', 'single object', 'full environment'];

    var polygonObjInv = ['show both', 'single object', 'full environment'];
    jQuery("#polygonObjInv").slider({
        min: 0,
        max: 2,
        value: parseInt($scope.environment),
        range: false
    }).slider("pips", {
        rest: 'label',
        labels: ['show both', 'single object', 'full environment']
    }).on("slidechange", function(e,ui) {
        $scope.environment = parseInt(ui.value);
    });

    jQuery("#countRange").slider({
        min: 0,
        max: 10,
        values: ($scope.poly_count_range && $scope.poly_count_range[1])? [$scope.poly_count_range[0],$scope.poly_count_range[1]] : [0,10],
        range: true,
        slide: function(event, ui) { return (ui.values[1] - ui.values[0] > 0); },
        create: function( event, ui ) {
            if($scope.poly_count_range) {
                jQuery(".polCount .first").text(countRanges[($scope.poly_count_range[0]) ? $scope.poly_count_range[0] : 0]);
                jQuery(".polCount .second").text(countRanges[($scope.poly_count_range[1]) ? $scope.poly_count_range[1] : countRangesLength]);
            }else{
                jQuery(".polCount .first").text(countRanges[0]);
                jQuery(".polCount .second").text(countRanges[countRangesLength]);
            }
        }
    }).slider("pips", {
        rest: 'label',
        labels: countRanges
    }).on("slidechange", function(e,ui) {
        jQuery(".polCount .first").text(countRanges[ui.values[0]]);
        jQuery(".polCount .second").text(countRanges[ui.values[1]]);
        console.log('ch poly');
        $scope.poly_count = '['+ui.values[0]+','+parseInt(parseInt(ui.values[1]))+']';


        $scope.poly_count_range = [];
            $scope.poly_count_range[0] = ui.values[0];
            $scope.poly_count_range[1] = ui.values[1];



    });






    jQuery("#productRating").slider({
        min: 0,
        max: 3,
        value: $scope.pr_rating-1,
        range: false,
        create: function( event, ui ) {
            jQuery("#product-rating-number").text(parseInt($scope.pr_rating));
        }
    }).slider("pips", {
        rest: 'label',
        labels: ['&#9733; >', '&#9733;&#9733; >', '&#9733;&#9733;&#9733; >', '&#9733;&#9733;&#9733;&#9733; >']
    }).on("slidechange", function(e,ui) {
        jQuery("#product-rating-number").text(parseInt(parseInt([ui.value]) + 1));
        $scope.pr_rating = parseInt(parseInt([ui.value])+1);
    });

}]);