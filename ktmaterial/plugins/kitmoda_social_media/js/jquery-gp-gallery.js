(function($) {
  $.fn.gpGallery = function(selector, options) {
    var $settings = {
        is_first_big: true,
        row_min_height: 180,
        row_max_height: 250,
        row_max_width: null,
        gutter: 10,
        call: true
    };
    if (options) {
        $.extend($settings, options);
    }

    function getWidthForBucket(bucket, extra) {
        var width = 0;
        if (bucket.length) {
            width = $settings.gutter * (bucket.length - 1);
            $.each(bucket, function(idx, item) {
                width += item.width;
            });
        }
        if (extra) {
            width += extra.width;
        }
        return width;
    }

    return this.each(function() {
        var $container = $(this);
        var max_bucket_width = $settings.row_max_width || $container.width();
        var buckets = [],
            last_bucket = {
                items: [],
                width: 0,
                height: 0
            };
        $container.find(selector).each(function() {
            var $this = $(this);
            var $pic = $this;


            if ($pic[0].nodeName.toUpperCase() != 'IMG') {
                $pic = $pic.find('img');
            } else {
                $this = $('<div>').insertBefore($pic).append($pic);
            }
            if (!$pic.length) return;

            $this.css({width: 'auto', float: 'left', position: 'relative'});

            var item = {
                pic: $pic,
                container: $this,
                original_height: $pic.height() || $pic.attr('height'),
                original_width: $pic.width() || $pic.attr('width')
            };
            item.aspect = item.original_width / item.original_height;
            item.scale = $settings.row_min_height / item.original_height;
            item.width = item.original_width * item.scale;
            item.height = item.original_height * item.scale;
            var new_bucket_width = getWidthForBucket(last_bucket.items, item);
            if (new_bucket_width > max_bucket_width) {
                buckets.push(last_bucket);
                last_bucket = {
                    items: [],
                    width: 0,
                    height: 0
                };
            }
            last_bucket.items.push(item);
        });
        buckets.push(last_bucket);
        last_bucket.last = true;

        $.each(buckets, function(idx, bucket) {
            if (!bucket.last) {
                bucket.scale = (max_bucket_width - (bucket.items.length - 1) * $settings.gutter) / getWidthForBucket(bucket.items);
            }
            var $last_item;

            $.each(bucket.items, function(idx2, item) {
                if (bucket.scale) {
                    item.width = Math.round(item.width * bucket.scale);
                    item.height = Math.round(item.height * bucket.scale);
                }
                var pic = item.pic,
                    container = item.container;
                $last_item = item;

                pic.css({
                    height: item.height+"px",
                    width: item.width+"px"
                });
                item.container.css({
                    height: item.height+"px",
                    width: item.width+"px",
                    marginTop: $settings.gutter + 'px'
                });
                if (idx2 > 0) {
                    item.container.css({
                        marginLeft: $settings.gutter + 'px'
                    });
                } else {
                    item.container.css({
                        clear: 'left'
                    });
                }
            });
            if (!bucket.last && $last_item) {
                $last_item.width = $last_item.width + max_bucket_width - getWidthForBucket(bucket.items);
                $last_item.pic.css({
                    width: $last_item.width + 'px'
                });
            }
        });
    });
  };
})(jQuery);
