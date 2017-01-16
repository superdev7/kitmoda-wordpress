;(function($) {

    var $formEditor = $('ul#fes-form-editor');

    var Editor = {
        init: function() {

            // make it sortable
            this.makeSortable();

            this.tooltip();
            this.tabber();
            this.showHideHelp();

            // on save validation
            $('form#post').submit(function(e) {
                var errors = false;
                $('li.custom-field input[data-type="label"]').each( function(index) {
                    if ($(this).val().length === 0) {
                        errors = true;
                        $(this).css('border', '1px solid #993333');
                    }
                });

                $('li.custom-field.custom_repeater input[type="text"]').each( function(index) {
                    if ( $(this).attr( 'name' ).indexOf("name") >= 0 && $(this).val().length === 0) {
                        errors = true;
                        $(this).css('border', '1px solid #993333');
                    }
                });

                if (errors) {
                    e.preventDefault();
                    alert( 'Please fix the errors to save the form.' );
                }

            });

            // collapse all
            $('button.fes-collapse').on('click', this.collapseEditFields);

            // add field click
            $('.fes-form-buttons').on('click', 'button', this.addNewField);

            // remove form field
            $('ul#fes-form-editor').on('click', '.fes-remove', this.removeFormField);

            // on change event: meta key
            $('ul#fes-form-editor').on('blur', 'li.custom-field input[data-type="label"]', this.setMetaKey);

            // on change event: checkbox|radio fields
            $('ul#fes-form-editor').on('change', '.fes-form-sub-fields input[type=text]', function() {
                $(this).prev('input[type=checkbox], input[type=radio]').val($(this).val());
            });

            // on change event: checkbox|radio fields
            $('ul#fes-form-editor').on('click', 'input[type=checkbox].multicolumn', function() {
                // $(this).prev('input[type=checkbox], input[type=radio]').val($(this).val());
                var $self = $(this),
                    $parent = $self.closest('.fes-form-rows');

                if ($self.is(':checked')) {
                    $parent.next().hide().next().hide();
                    $parent.siblings('.column-names').show();
                } else {
                    $parent.next().show().next().show();
                    $parent.siblings('.column-names').hide();
                }
            });

            // on change event: checkbox|radio fields
            $('ul#fes-form-editor').on('click', 'input[type=checkbox].retype-pass', function() {
                // $(this).prev('input[type=checkbox], input[type=radio]').val($(this).val());
                var $self = $(this),
                    $parent = $self.closest('.fes-form-rows');

                if ($self.is(':checked')) {
                    $parent.next().show().next().show();
                } else {
                    $parent.next().hide().next().hide();
                }
            });

            // toggle form field
            $('ul#fes-form-editor').on('click', '.fes-toggle', this.toggleFormField);

            // clone and remove repeated field
            $('ul#fes-form-editor').on('click', 'img.fes-clone-field', this.cloneField);
            $('ul#fes-form-editor').on('click', 'img.fes-remove-field', this.removeField);
        },

        showHideHelp: function() {
            var childs = $('ul#fes-form-editor').children('li');

            if ( !childs.length) {
                $('.fes-updated').show();
            } else {
                $('.fes-updated').hide();
            }
        },

        makeSortable: function() {
            $formEditor = $('ul#fes-form-editor');

            if ($formEditor) {
                $formEditor.sortable({
                    placeholder: "ui-state-highlight",
                    handle: '> .fes-legend',
                    distance: 5
                });
            }
        },

        addNewField: function(e) {
            e.preventDefault();

            var $self = $(this),
                $formEditor = $('ul#fes-form-editor'),
                name = $self.data('name'),
                type = $self.data('type'),
                data = {
                    name: name,
                    type: type,
                    order: $formEditor.find('li').length + 1,
                    action: 'fes-form_add_el'
                };

            // console.log($self, data);

            // check if these are already inserted
            var oneInstance = ['user_login', 'first_name', 'last_name', 'nickname', 'display_name', 'user_email', 'user_url',
                'user_bio', 'password', 'user_avatar', 'post_title', 'post_content', 'featured_image', 'download_category',
				'download_tag','multiple_pricing','post_excerpt','eddc_user_paypal', 'edd_ap'];

            if ($.inArray(name, oneInstance) >= 0) {
                if( $formEditor.find('li.' + name).length ) {
                    alert('You already have this field in the form');
                    return false;
                }
            }

            var buttonText = $self.text();
            $self.html('<div class="fes-loading"></div>');
            $self.attr('disabled', 'disabled');
            $.post(ajaxurl, data, function(res) {
                $formEditor.append(res);

                // re-call sortable
                Editor.makeSortable();

                // enable tooltip
                Editor.tooltip();

                $self.removeAttr('disabled');
                $self.text(buttonText);
                Editor.showHideHelp();
            });
        },

        removeFormField: function(e) {
            e.preventDefault();

            if (confirm('Are you sure?')) {

                $(this).closest('li').fadeOut(function() {
                    $(this).remove();

                    Editor.showHideHelp();
                });
            }
        },

        toggleFormField: function(e) {
            e.preventDefault();

            $(this).closest('li').find('.fes-form-holder').slideToggle('fast');
        },

        cloneField: function(e) {
            e.preventDefault();

            var $div = $(this).closest('div');
            var $clone = $div.clone();
            // console.log($clone);

            //clear the inputs
            $clone.find('input').val('');
            $clone.find(':checked').attr('checked', '');
            $div.after($clone);
        },

        removeField: function() {
            //check if it's the only item
            var $parent = $(this).closest('div');
            var items = $parent.siblings().andSelf().length;

            if( items > 1 ) {
                $parent.remove();
            }
        },

        setMetaKey: function() {
            var $self = $(this),
                val = $self.val().toLowerCase().split(' ').join('_').split('\'').join(''),
                $metaKey = $(this).closest('.fes-form-rows').next().find('input[type=text]');

            if ($metaKey.length) {
                $metaKey.val(val);
            }
        },

        tooltip: function() {
            $('.smallipopInput').smallipop({
                preferredPosition: 'right',
                theme: 'black',
                popupOffset: 0,
                triggerOnClick: true
            });
        },

        collapseEditFields: function(e) {
            e.preventDefault();

            $('ul#fes-form-editor').children('li').find('.fes-form-holder').slideToggle();
        },

        tabber: function() {
            // Switches option sections
            $('.group').hide();
            $('.group:first').fadeIn();

            $('.group .collapsed').each(function(){
                $(this).find('input:checked').parent().parent().parent().nextAll().each(
                function(){
                    if ($(this).hasClass('last')) {
                        $(this).removeClass('hidden');
                        return false;
                    }
                    $(this).filter('.hidden').removeClass('hidden');
                });
            });

            $('.nav-tab-wrapper a:first').addClass('nav-tab-active');

            $('.nav-tab-wrapper a').click(function(evt) {
                var clicked_group = $(this).attr('href');
                if ( clicked_group.indexOf( '#' ) >= 0 ) {
                    evt.preventDefault();
                    $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active').blur();
                    $('.group').hide();
                    $(clicked_group).fadeIn();
                }
            });
        }
    };

    // on DOM ready
    $(function() {
        Editor.init();
    });

})(jQuery);