;(function ($) {
    var product_featured_frame;
    var avatar_frame;
    var FES_Form = {
        init: function () {
            // clone and remove repeated field
            $('.fes-form').on('click', 'img.fes-clone-field', this.cloneField);
            $('.fes-form').on('click', 'img.fes-remove-field', this.removeField);

            // form submissions
            $('.fes-submission-form').on('submit', this.formSubmit);
            $('.fes-form-login-form').on('submit', this.formSubmit);
            $('.fes-profile-form').on('submit', this.formSubmit);
            $('.fes-form-registration-form').on('submit', this.formSubmit);
            $('.fes-form-vendor-contact-form').on('submit', this.formSubmit);

            // featured image
            $('.fes-fields').on('click', 'a.fes-feat-image-btn', this.featuredImage.addImage);
            $('.fes-fields').on('click', 'a.fes-remove-feat-image', this.featuredImage.removeImage);

            // featured image
            $('.fes-fields').on('click', 'a.fes-avatar-image-btn', this.avatarImage.addImage);
            $('.fes-fields').on('click', 'a.fes-remove-avatar-image', this.avatarImage.removeImage);

            // download links
            $('.fes-fields').on('click', 'a.upload_file_button', this.fileDownloadable);

            // Repeatable file inputs
            $('.fes-fields').on('click', 'a.insert-file-row', function (e) {
                e.preventDefault();
                var clickedID = $(this).attr('id');
                var max = $('#fes-upload-max-files-'+clickedID ).val();
                var optionContainer = $('.fes-variations-list-'+clickedID);
                var option = optionContainer.find('.fes-single-variation:last');
                var newOption = option.clone();
                delete newOption[1];
                newOption.length = 1;
                var count = optionContainer.find('.fes-single-variation').length;

                // too many files 
                if ( count + 1 > max && max != 0 ){
                    return alert(fes_form.too_many_files_pt_1 + max + fes_form.too_many_files_pt_2);
                }

                newOption.find('input, select, textarea').val('');
                newOption.find('input, select, textarea').each(function () {
                    var name = $(this).attr('name');
                    name = name.replace(/\[(\d+)\]/, '[' + parseInt(count) + ']');
                    $(this)
                        .attr('name', name)
                        .attr('id', name);

                    newOption.insertBefore("#"+clickedID);
                });
                return false;
            });


            $('.fes-fields').on('click', 'a.delete', function (e) {
                e.preventDefault();
                var option = $(this).parents('.fes-single-variation');
                var optionContainer = $(this).parents('[class^=fes-variations-list-]');
                var count = optionContainer.find('.fes-single-variation').length;

                if (count == 1) {
                    return alert(fes_form.one_option);
                } else {
                    option.remove();
                    return false;
                }
            });
        },

        avatarImage: {

            addImage: function (e) {
                e.preventDefault();

                var self = $(this);

                if (avatar_frame) {
                    avatar_frame.open();
                    return;
                }

                avatar_frame = wp.media({
                    title: fes_form.avatar_title,
                    button: {
                        text: fes_form.avatar_button,
                    },
                    library: {
                        type: 'image',
                    }
                });

                avatar_frame.on('select', function () {
                    var selection = avatar_frame.state().get('selection');

                    selection.map(function (attachment) {
                        attachment = attachment.toJSON();

                        // set the image hidden id
                        self.siblings('input.fes-avatar-image-id').val(attachment.id);

                        // set the image
                        var instruction = self.closest('.instruction-inside');
                        var wrap = instruction.siblings('.image-wrap');

                        // wrap.find('img').attr('src', attachment.sizes.thumbnail.url);
                        wrap.find('img').attr('src', attachment.url);

                        instruction.addClass('fes-hide');
                        wrap.removeClass('fes-hide');
                    });
                });

                avatar_frame.open();
            },

            removeImage: function (e) {
                e.preventDefault();

                var self = $(this);
                var wrap = self.closest('.image-wrap');
                var instruction = wrap.siblings('.instruction-inside');

                instruction.find('input.fes-avatar-image-id').val('0');
                wrap.addClass('fes-hide');
                instruction.removeClass('fes-hide');
            }
        },

        fileDownloadable: function (e) {
            e.preventDefault();

            var self = $(this),
                downloadable_frame;

            if (downloadable_frame) {
                downloadable_frame.open();
                return;
            }

            downloadable_frame = wp.media({
                title: fes_form.file_title,
                button: {
                    text: fes_form.file_button,
                },
                multiple: false
            });

            downloadable_frame.on('select', function () {
                var selection = downloadable_frame.state().get('selection');

                selection.map(function (attachment) {
                    attachment = attachment.toJSON();

                    self.closest('tr').find('input.fes-file-value').val(attachment.url);
                });
            });

            downloadable_frame.open();
        },


        featuredImage: {

            addImage: function (e) {
                e.preventDefault();

                var self = $(this);

                if (product_featured_frame) {
                    product_featured_frame.open();
                    return;
                }

                product_featured_frame = wp.media({
                    title: fes_form.feat_title,
                    button: {
                        text: fes_form.feat_button,
                    },
                    library: {
                        type: 'image',
                    }
                });

                product_featured_frame.on('select', function () {
                    var selection = product_featured_frame.state().get('selection');

                    selection.map(function (attachment) {
                        attachment = attachment.toJSON();

                        //console.log(attachment, self);
                        // set the image hidden id
                        self.siblings('input.fes-feat-image-id').val(attachment.id);

                        // set the image
                        var instruction = self.closest('.instruction-inside');
                        var wrap = instruction.siblings('.image-wrap');

                        // wrap.find('img').attr('src', attachment.sizes.thumbnail.url);
                        wrap.find('img').attr('src', attachment.url);

                        instruction.addClass('fes-hide');
                        wrap.removeClass('fes-hide');
                    });
                });

                product_featured_frame.open();
            },

            removeImage: function (e) {
                e.preventDefault();

                var self = $(this);
                var wrap = self.closest('.image-wrap');
                var instruction = wrap.siblings('.instruction-inside');

                instruction.find('input.fes-feat-image-id').val('0');
                wrap.addClass('fes-hide');
                instruction.removeClass('fes-hide');
            }
        },

        cloneField: function (e) {
            e.preventDefault();

            var $div = $(this).closest('tr');
            var $clone = $div.clone();
            var $trs = $div.parent().find('tr');

            var key = highest = 0;
            $trs.each(function() {
                var current = $(this).data( 'key' );
                if( parseInt( current ) > highest ) {
                    highest = current;
                }
            });
            key = highest + 1;

            //clear the inputs
            $clone.attr( 'data-key', parseInt( key ) );
            $clone.find(':checked').attr('checked', '');
            $clone.find('input, select, textarea').val('');
            $clone.find('input, select, textarea').each(function () {
                var name = $(this).attr('name');
                name = name.replace(/\[(\d+)\]/, '[' + parseInt(key) + ']');
                $(this).attr('name', name).attr('id', name);
            });

            $div.after($clone);
        },

        removeField: function () {
            //check if it's the only item
            var $parent = $(this).closest('tr');
            var items = $parent.siblings().andSelf().length;

            if (items > 1) {
                $parent.remove();
            }
        },

        formSubmit: function (e) {
            e.preventDefault();

            var form = $(this),
                form_error_field = form.find('.fes-form-error')
                submitButton = form.find('input[type=submit]')
                form_data = FES_Form.validateForm(form);

            if (form_error_field.length) {
                form_error_field.hide();
            }

            if (form_data) {
                // send the request
                form.find('fieldset.fes-submit').append('<span class="fes-loading"></span>');
                submitButton.attr('disabled', 'disabled').addClass('button-primary-disabled');
                $.post(fes_form.ajaxurl, form_data, function (res) {
                    //var res = $.parseJSON(res);
                    if ( window.console && window.console.log ) {
                        console.log( res );
                    }
                    if (res.success) {
                        form.before('<div class="fes-success">' + res.message + '</div>');
                        if (res.is_post) {
                            form.slideUp('fast', function () {
                                form.remove();
                            });
                        }

                        //focus
                        $('html, body').animate({
                            scrollTop: $('.fes-success').offset().top - 100
                        }, 'fast');

                        setTimeout(
                            function () {
                                window.location = res.redirect_to;
                            }, 1000);
                    } else {
                        if ( form_error_field.length ) {
                            form_error_field.text(res.error);
                            form_error_field.show();
                        } else {
                            alert(res.error);
                        }
                        submitButton.removeAttr('disabled');
                    }

                    submitButton.removeClass('button-primary-disabled');
                    form.find('span.fes-loading').remove();
                });
            }
        },

        validateForm: function (self) {

            var temp,
                temp_val = '',
                error = false,
                error_items = [];

            FES_Form.removeErrors(self);
            FES_Form.removeErrorNotice(self);

            var required = self.find('[data-required="yes"]');

            required.each(function (i, item) {
                var data_type = $(item).data('type')
                val = '';

                switch (data_type) {
                case 'rich':
                    var name = $(item).data('id')
                    val = $.trim(tinyMCE.get(name).getContent());

                    if (val === '') {
                        error = true;
                        FES_Form.markError(item);
                    }
                    break;

                case 'textarea':
                case 'text':
                    val = $.trim($(item).val());

                    if (val === '') {
                        error = true;
                        FES_Form.markError(item);
                    }
                    break;

                case 'select':
                    val = $(item).val();
                    if (!val || val === '-1') {
                        error = true;
                        FES_Form.markError(item);
                    }
                    break;

                case 'multiselect':
                    val = $(item).val();

                    if (val === null || val.length === 0) {
                        error = true;
                        FES_Form.markError(item);
                    }
                    break;

                case 'tax-checkbox':
                    var length = $(item).children().find('input:checked').length;

                    if (!length) {
                        error = true;
                        FES_Form.markError(item);
                    }
                    break;

                case 'radio':
                    var length = $(item).parent().find('input:checked').length;

                    if (!length) {
                        error = true;
                        FES_Form.markError(item);
                    }
                    break;

                case 'image':
                    var length = $(item).next().val();
                    if (length === null || length === 0 || length === '' || length === "0" ) {
                        error = true;
                        FES_Form.markError(item);
                    }
                    break;

                case 'file':
                    var length = $(item).next('input.fes-file-value').val();
                    if (length === null || length === 0 || length === '' ) {
                        error = true;
                        FES_Form.markError(item);
                    }
                    else{
                        if (!FES_Form.isValidURL(length)) {
                            error = true;
                            FES_Form.markError(item);
                        }

                    }
                    break;

                case 'email':
                    var val = $(item).val();

                    if (val !== '') {
                        if (!FES_Form.isValidEmail(val)) {
                            error = true;
                            FES_Form.markError(item);
                        }
                    }
                    break;


                case 'url':
                    var val = $(item).val();

                    if (val !== '') {
                        if (!FES_Form.isValidURL(val)) {
                            error = true;
                            FES_Form.markError(item);
                        }
                    }
                    break;

                 case 'checkbox':
                        var length = $(item).parent().find('input:checked').length;

                        if ( ! length ) {
                            error = true;
                            FES_Form.markError(item);
                        }
                        break;     

                case 'multiple':
                    var file = $(item).closest('.fes-single-variation').find('input.fes-file-value').val();
                    var price = $(item).closest('.fes-single-variation').find('input.fes-price-value').val();
                    var name = $(item).closest('.fes-single-variation').find('input.fes-name-value').val();
                    
                    var file_exists = false;
                    if($('#fes-file-row-js').length){
                        file_exists = true;
                    }


                    var price_exists = false;
                    if($('#fes-price-row-js').length){
                        price_exists = true;
                    }


                    var name_exists = false;
                    if($('#fes-name-row-js').length){
                        name_exists = true;
                    }

                    // file
                    if ( file_exists && ( file === '' || !FES_Form.isValidURL(file) ) ) {
                        error = true;
                        FES_Form.markError(item);
                    }

                    // price
                    if ( price_exists && price === '' ){
                        error = true;
                        FES_Form.markError(item);
                    }
                   
                    // name
                    if ( name_exists && name === ''  ){
                        error = true;
                        FES_Form.markError(item);
                    }
                    break;
                };

            });

            // if error found, bail out
            if (error) {
                // add error notice
                FES_Form.addErrorNotice(self);
                return false;
            }

            var form_data = self.serialize(),
                rich_texts = [];

            // grab rich texts from tinyMCE
            $('.fes-rich-validation').each(function (index, item) {
                temp = $(item).data('id');
                val = $.trim(tinyMCE.get(temp).getContent());

                rich_texts.push(temp + '=' + encodeURIComponent(val));
            });

            // append them to the form var
            form_data = form_data + '&' + rich_texts.join('&');
            return form_data;
        },

        addErrorNotice: function (form) {
            $(form).find('fieldset.fes-submit').append('<div id="fes-error-div" class="fes-error edd_errors">' + fes_form.error_message + '</div>');
        },

        removeErrorNotice: function (form) {
            $(form).find('#fes-error-div').remove();
        },

        markError: function (item) {
            $(item).closest('fieldset').addClass('has-error');
            $(item).focus();
        },

        removeErrors: function (item) {
            $(item).find('.has-error').removeClass('has-error');
        },

        isValidEmail: function (email) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return pattern.test(email);
        },

        isValidURL: function (url) {
            var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|files.|ftp:\/\/www.|www.|http:\/\/|https:\/\/){1}([0-9A-Za-z]+\.)|.+\.(?:" + fes_form.file_types + ")");
            return urlregex.test(url);
        },
    };

    $(function () {
        FES_Form.init();
    });

})(jQuery);
