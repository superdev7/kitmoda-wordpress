var avatar_uploader = function(params) {
    
    //'use strict';
    
    var _this = this;
    
    var defaults = {
	files : new Array(),
        PLU : null,
        is_completed : true,
        num_errors : 0,
        current_file : null,
        
        inlineStatus : null
        
        
        };
        
        
        
        
        params = params || {};
        for (var prop in defaults) {
            if (prop in params && typeof params[prop] === 'object') {
                for (var subProp in defaults[prop]) {
                    if (! (subProp in params[prop])) {
                        params[prop][subProp] = defaults[prop][subProp];
                    }
                }
            }
            else if (! (prop in params)) {
                params[prop] = defaults[prop];
            }
        }
        _this.params = params;
        
        
    
    
      

        _this.process_queue = function(up, file) {
            _this.params.current_file = file;
            jQuery('.avatar .progress .bar').width(file.percent+'%');
        }
        
        
        _this.queue_error_file = function(error) {
            var file = error.file;
            var $ele = jQuery('<li id="'+file.id+'" class="file error">\
            <div class="preview">\
                <span class="error_note">'+error.message+'</span>\
                <div class="thumbnail">\
                    <div class="filename">'+trancateTitle(file.name)+ ' - ' +formate_size(file.size)+'</div>\
                </div>\
                <br class="clear">\
            </div>\
            <input type="hidden" name="multi_images[]" class="wall_img" value="">\
            </li>');

            jQuery($ele).insertBefore('.files_list li.clr');
            
            setTimeout(function(){
                $ele.fadeOut();
            }, 3000)
        }
        
        
        
        



        

        _this.queue_file = function(file) {
            var $ele = jQuery('<div class="progress"><div class="percent"></div><div class="bar"></div></div>');
            jQuery('.avatar').prepend($ele)
        }

        

        _this.uploadSuccess = function(u, f, r){
            var o = jQuery.parseJSON(r.response);
            if(o.success) {
                jQuery('.avatar .progress').remove();
                jQuery('.avatar img').attr('src', o.url);
                jQuery('.avatar #avatar_id').val(o.id);
            }
        }
    
        _this.plu_before_upload = function(up, file) {
            up.settings.multipart_params = {
                action : _this.params.action,
                fileid: file.id, 
                size:file.size,
                _ajax_nonce : _this.params.nonce
            }
        }
    
        
        
        
        _this.setComplete = function() {
            _this.params.is_completed = true;
        }
    
    _this.init = function() {
        
        
        
        _this.params.PLU = new plupload.Uploader({
            url : edd_scripts.ajaxurl,
            file_data_name : 'async-upload',
            runtimes : 'html5,flash',
            multipart: true,
            max_file_size: _this.params.max_size,
            max_retries: 2,
            multi_selection : false,
            browse_button : jQuery('.edit_profile .browse_btn').get(0),
            container: jQuery('.upload_window .content').get(0),
            flash_swf_url : ksm_settings.plu.flash_swf_url,
            filters : [
                {title : "Images", extensions : _this.params.file_types}
            ],
            
            preinit : {
                
                Error: function(up, err, a) {
                   if(err.code == plupload.FILE_SIZE_ERROR || err.code == plupload.FILE_EXTENSION_ERROR) {
                        _this.queue_error_file(err);
                        
                   }
		}
                
            },
            
            init: {
                FilesAdded: function(up, files) {
                    
			plupload.each(files, function(file) {
                            _this.params.files.push(file);
                            _this.queue_file(file)
			});

                        if(_this.params.PLU.state != plupload.UPLOADING) {
                            _this.params.PLU.start();
                        }
		},

		UploadProgress : function(up, file) {_this.process_queue(up, file);},
                FileUploaded : function(up, file, res) { _this.uploadSuccess(up, file, res);},
                BeforeUpload : function(up, file) {_this.plu_before_upload(up, file)},

		
                
                StateChanged : function(up) {
                    //if(up.state == plupload.STOPPED && _this.params.PLU.total.queued > 0){
                    //    up.start()
                    //}
                },
                
                UploadComplete : function(up, s) {_this.setComplete();}
                
            }
        });
        
        
    }
    _this.init();
    
    
    
    
    
}