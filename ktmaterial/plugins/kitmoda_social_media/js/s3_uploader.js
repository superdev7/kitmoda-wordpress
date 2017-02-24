

var kuldr = Base.extend({
    
    
    format_time : function (t) {
        var sec = 60;
        var min = sec*sec;
        var hr = min*24;
	
	if(t < sec) {
            return parseInt(t)+" secs left";
	} else if(t > sec && t < min) {
            return parseInt(t/sec)+" mins left";
	} else if(t > min) {
            return parseInt(t/min)+" hours left";
        }
    } ,
    
    
    
    
    
    shortTitle : function(title) {
        var length = 50;
        if (title.length > length) {
            var left = title.substr(0,40);
            var right = title.substr((title.length - 7));
            return left.toString()+"..."+right.toString();
        }
        return title;
    } ,
    
    
    
    process_queue : function(up, file) {
        this.current_file = file;
        var item_ele = this.container+' #'+file.id;
        
        if($(item_ele+' .progress .bar').length > 0) {
            $(item_ele+' .progress .bar').width(file.percent+'%');
        }
        
        if($(item_ele+' .percent').length > 0) {
            $(item_ele+' .percent').html(file.percent+'%');
        }
    },
    
    
    
    
    queue_error_file : function(error) {
        var file = error.file;
        var $ele = jQuery('<li id="'+file.id+'" class="file error">\
            <div class="preview">\
                <span class="error_note">'+error.message+'</span>\
                <div class="thumbnail">\
                    <div class="filename">'+trancateTitle(file.name)+ ' - ' +formate_size(file.size)+'</div>\
                </div>\
                <br class="clear">\
            </div>\
            <input type="hidden" name="multi_images[]" class="uid" value="">\
            </li>');

        $($ele).insertBefore('.items li.clr');
        setTimeout(function(){$ele.fadeOut();}, 3000)
    } ,
    
    queue_file : function(file) {
        
        var _this = this;
        
        
        if(_this.queue_item) {
            var item = _this.queue_item;
        } else if(_this.queue_element) {
            var item = $(_this.queue_element).clone().html();
        }
        
        
        var name = (file.name).substr(0, (file.name).lastIndexOf('.')) || file.name;

        
        var item = item
                .replace(/{filekey}/gi, file.id)
                .replace(/{filename}/gi, file.name)
                .replace(/{name}/gi, name)
                .replace(/{filesize}/gi, plupload.formatSize(file.size));
        
        
        if($(_this.empty_div).length > 0) {
            $(_this.empty_div).hide();
        }
        
        
        
        if($(_this.container+' .items li.clr.items_clr').length > 0) {
            $(item).insertBefore(_this.container+' .items li.clr');
        } else {
            $(_this.container+' .items').append(item);
        }
        
        
        
        
        $(_this.container).trigger( "onItemAdded", [file.id] );
        
        
        if($(this.container+" .btn_form_smt").length > 0) {
            $(this.container+" .btn_form_smt").addClass('uploadip');
        }
        
    } ,
    
    //remove : function(id) {
    //    $(this.container+' .items li#'+id).remove();
    //    $(this.container).trigger( "onItemRemove" );
    //},
    
    uploadSuccess : function(u, f, r) {
        var o = $.parseJSON(r.response);
        var item_ele = this.container+' #'+f.id;
            
        $(item_ele+' .progress').remove();
        $(item_ele+' .percent').remove();
        
        $(item_ele+' .preview .thumbnail').removeClass('empty').html('<img src="'+o.url+'" width="100%" height="100%" />');
        $(item_ele+' .uid').val(o.id);
        $(item_ele+' .cancel').removeClass('cancel').addClass('remove');
    },
    
    
    
    
    
    
    
    
    
    
    /*
    plu_before_upload : function(up, file) {
        up.settings.multipart_params = {
            action : this.action,
            fileid: file.id, 
            size:file.size,
            _ajax_nonce : this.nonce
        }
    },
    
    */
    
    
    plu_before_upload : function(up, file) {
        up.settings.multipart_params = jQuery.extend(true, {}, this.m_p);
        
        if(this.iss3) {
            
            var k = (this.m_p.key).replace('{id}', file.id);
            file.s3Key = k+file.name;
            up.settings.multipart_params.key = file.s3Key;
            up.settings.multipart_params.Filename = file.s3Key;
            //console.log(file.type);
            if(this.setCT) {
                up.settings.multipart_params["Content-Type"] = file.type
            }
            
        }
    },
    
    
    
        
    setComplete : function() {
        
        this.is_completed = true;
        
        
        if($(this.container+" .btn_form_smt").length > 0) {
            $(this.container+" .btn_form_smt").removeClass('uploadip');
            
            if($(this.container+" .btn_form_smt").hasClass('tooltipstered')) {
                $(this.container+" .btn_form_smt").tooltipster('destroy');
            }
        }
    } ,
    
    isFileSizeChunkableOnS3 : function( fileSize ) {
        var minSize = plupload.parseSize(this.chunk_size);
        return( fileSize > minSize );
    },
    
    setDropzone : function() {
        
        
        var _this = this;
        
        $(_this.drop_element).each(function() {
            var _ele = this;
            var dropzone = new mOxie.FileDrop({
                drop_zone: _ele
            });
            dropzone.ondrop = function( event ) {
                $(_ele).removeClass('dragenter');
                
                if(dropzone.files.length < 1) {
                    return;
                }
                
                if(_this.max_files == 1) {
                    _this.PLU.addFile( dropzone.files[0] );
                } else {
                    _this.PLU.addFile( dropzone.files );
                }
                
                
                
            };
            dropzone.ondragenter = function(event) {
                $(_ele).addClass('dragenter');
            };
            dropzone.ondragleave = function(event) {
                
                
                
                if($(_ele).closest('.dropbox').length == 0) {
                    $(_ele).removeClass('dragenter');
                }
            };
            dropzone.init();
        });
        
        
        
        
        
        
        
        
        
        //this.PLU.settings.drop_element = $(this.drop_element);
    },
    
    
    files_limit_exceeded : function () {
        var _this = this;
        $(_this.browse_button).tooltipster({content: 'The upload limit for images of 12 has been exceeded.',once : true});
        $(_this.browse_button).tooltipster('show');
        
        setTimeout(function() {
            if($(_this.browse_button).hasClass('tooltipstered')) {
                $(_this.browse_button).tooltipster('destroy');
            }
        }, 4000);
    },
    
    
    filesAdded : function(up, files) {
        
        
    
        
        
        
        
        
        var _this = this;
        
        if(_this.max_files == 1) {
            console.log(_this.max_files);
            $(_this.container+ ' .items .item').each(function() {
                _this.cancelFile($(this).attr('id'));
            });
        }
        
        
        
        
        plupload.each(files, function(file) {
            
            //console.log(_this.max_files, $(_this.container+ ' .items .item').length)
        
            if(_this.max_files && $(_this.container+ ' .items .item').length >= _this.max_files) {
               // _this.files_limit_exceeded();
               // $(_this.container).trigger('files_limit_exceeded');
               // return false;
			   return;
            }
            
            
            _this.files.push(file);
            _this.queue_file(file);
        });
        
		//Comment this out later
        //up.refresh();
        
        if(_this.PLU.state != plupload.UPLOADING) {
            _this.PLU.start();
        }
        
    } ,
    
    
    cancelFile : function(fid) {
        this.PLU.removeFile(fid);
        this.removeFile(fid);
    },
        
        
    removeFile : function(fid) {
        $(this.container+' li.item#'+fid).remove();
        if($(this.container+ ' .items li.item').length == 0 && $(this.empty_div).length > 0) {
            $(this.empty_div).show();
        }
        $(this.container).trigger("onItemRemove");
    },
    
    
    setSort : function() {
        $(this.container+' .items').sortable({
            scroll : false,
            cursor: "move",
            opacity: 0.5,
            placeholder  : 'sortable-placeholder'
        });
    },
    
    constructor : function(params) {
        
        
        var defaults = {
            files : new Array(),
            PLU : null,
            is_completed : true,
            num_errors : 0,
            current_file : null,

            inlineStatus : null,
            m_p : {},
            url : '',
            max_size : '50mb',
            file_types : '*',
            max_files : 0,
            chunk_size : '5mb',
            browse_button : '',
            container : '',
            drop_element : '',
            iss3 : false,
            file_data_name : 'async-upload',
            sa : '',
            setCT : false,
            sortable : false,
            queue_item : '',
            queue_element : '',
            empty_div : ''
        };
        
        
        
        params = params || {};
        for (var prop in defaults) {
            if (prop in params && typeof params[prop] === 'object') {
                for (var subProp in defaults[prop]) {
                    if (! (subProp in params[prop])) {
                        params[prop][subProp] = defaults[prop][subProp];
                    }
                }
            } else if (! (prop in params)) {
                params[prop] = defaults[prop];
            }
        }
        
        
        
        this.files = new Array();
        this.is_completed = true;
        this.current_file = null;
        this.m_p = params.m_p;
        this.url = params.url;
        this.max_size = params.max_size;
        this.file_types = params.file_types;
        this.max_files = params.max_files;
        this.min_files = params.min_files;
        this.chunk_size = params.chunk_size;
        this.browse_button = params.browse_button;
        this.container = params.container;
        this.drop_element = params.drop_element;
        this.iss3 = params.iss3;
        this.file_data_name = params.file_data_name;
        this.sa = params.sa;
        this.setCT = params.setCT;
        this.sortable = params.sortable;
        this.sort_start_index = -1;
        this.queue_item = params.queue_item;
        this.queue_element = params.queue_element;
        this.empty_div = params.empty_div;
        
        var _this = this;
        
        
        var ms = _this.max_files == 1 ? false : true;
        
        
        this.PLU = new plupload.Uploader({
            url : _this.url,
            file_data_name : _this.file_data_name,
            runtimes : 'html5,flash,silverlight,html4',
            multipart: true,
            max_file_size: _this.max_size,
            max_retries: 1,
            browse_button : $(_this.browse_button).get(0),
            container: $(_this.container).get(0),
            flash_swf_url : ksm_settings.plu.flash_swf_url,
            filters : [
                {title : "Images", extensions : _this.file_types}
            ],
            multi_selection: ms,
            preinit : {
                Error: function(up, err, a) {
                    
                   if(err.code == plupload.FILE_SIZE_ERROR || err.code == plupload.FILE_EXTENSION_ERROR) {
                       
                       _this.queue_error_file(err);
                   }
		}
                
            },
            
            init: {
                FilesAdded: function(up, files) {_this.filesAdded(up, files);},
		UploadProgress : function(up, file) {_this.process_queue(up, file);},
                FileUploaded : function(up, file, res) {_this.uploadSuccess(up, file, res);},
                BeforeUpload : function(up, file) {_this.plu_before_upload(up, file)},
                UploadComplete : function(up, s) {_this.setComplete();},
                StateChanged : function(up) {
                    //console.log(up.state);
                    //if(up.state == plupload.STOPPED && _this.params.PLU.total.queued > 0){
                    //    up.start()
                    //}
                }
                
                
            }
        });
        
        
        if(this.drop_element && $(this.drop_element).length > 0) {
            this.setDropzone();
        }
        
        
        $(this.container).delegate('.items .item .remove', 'click', function(e) {
            e.preventDefault();
            _this.removeFile($(this).closest('li.item').attr('id'));
        });
        
        
        $(this.container).delegate('.items .item .cancel', 'click', function(e) {
            _this.cancelFile($(this).closest('li.item').attr('id'));
        });
        
        
        if(this.sortable) {
            
            $(this.container+" li.poslock").each(function () {
                $(this).attr("id", "poslock-" + $(this).index());
            });
            //_this.setSort();
			this.setDragDrop();
        }
        
        this.PLU.init();
        
        
    }
    
    
    
});





kniu = kuldr.extend({
    
});


kuaiu = kniu.extend({
    
    
    queue_file : function(file) {
        console.log(this);
        this.base(file);
        var _tis = $('.current_avatar').val();
        $('.avatar_container .items .item:first .thumbnail img').attr('src', _tis);
    },
    
    uploadSuccess : function(u, f, r) {
        this.base(u, f, r);
        var o = $.parseJSON(r.response);
        $('.current_avatar').val(o.url);
    }
});





////////////////////////////////////////////////////////////



var ks3uplr = kuldr.extend({
    constructor : function(params) {
        params.file_data_name = 'file';
        this.base(params);
    },
    
    
    
    
    
    
    
    uploadSuccess : function(u, f, r) {
        var item = this.container+' #'+f.id;
        
        
        $(item+' .progress').remove();
        $(item+' .percent').remove();
        $(item+' .upload_progress').html('').addClass('processing');
        $(item+' .small-x-button').hide();
        
        
        //$(item+ ' .processing').show();
        //$(item+ ' .remove').removeClass('remove').addClass('processing');
        
        if(this.sa) {
            var d = this.sa;
            d.k = f.s3Key;
            $.ajax({type : 'POST',url:ksm_settings.ajax_url,data : this.sa,success: function (r) {
				console.log(r);
                o = $.parseJSON(r);    
                if(o.success) {
                    $(item+ ' .uid').val(o.k);
                    $(item+ ' .small-x-button').show();
                    $(item+ ' .upload_progress').html('');
                    $(item+ ' .upload_progress').removeClass('processing').addClass('uploaded');
                }
                
                
            }});
        }
    },
    
});










var kimgupl = kuldr.extend({
    
    //init : function(params) {
//        this._super(params);
//    } ,
    
    
    
    
    queue_error_file : function(err) {
        
    },
    
    
    queue_file : function(file) {
        
        _this = this;
        $ele = $($(this.container+ ' .item.empty').get(0));
        
        $ele.attr('id', file.id).removeClass('empty').find('.progress, .percent').show();
        $ele.find('.cancel').show();
            
            
    } ,
    removeFile : function(fid) {
        $(this).closest('li.item#'+fid).remove();
        $(this.container).trigger("onItemRemove");
    } ,
    
    
    plu_before_upload : function(up, file) {
        
        
        
        up.settings.multipart_params = {
            action : this.m_p.action,
            at:this.m_p.at,
            _ajax_nonce : this.m_p._ajax_nonce,
            fileid: file.id, 
            size:file.size
        }
    },
    
   /* uploadSuccess : function(u, f, r) {
        var o = $.parseJSON(r.response);
        
        if(o.success) {
            
            var item_ele = this.container+' .item#'+f.id;
            
            $(item_ele+' .progress').hide();
            $(item_ele+' .percent').hide();
            $(item_ele+' .b3').html('<img src="'+o.url+'" width="100%" height="100%" />');
            $(item_ele+' .uid').val(o.id);
            $(item_ele+' .cancel').removeClass('cancel').addClass('remove');
            
        }
    },*/
     uploadSuccess : function(u, f, r) {
        var o = $.parseJSON(r.response);
        
        if(o.success) {
            var item_ele = this.container+' .item#'+f.id;
            $(item_ele+' .progress').hide();
            $(item_ele+' .percent').hide();
			//Commented code to display images after successful upload with new one that have remove button
            //$(item_ele+' .img').html('<a class="cancel"></a><img class="pub_feature" src="'+o.sizes.pub_feature+'" width="100%" height="100%" /><img class="pub_thumb" src="'+o.sizes.pub_thumb+'" width="100%" height="100%" />');
            
			//New code with remove button
			$(item_ele+' .b3').html('<a class="cancel"></a><img class="pub_feature" src="'+o.sizes.pub_feature+'" width="100%" height="100%" /><img class="pub_thumb" src="'+o.sizes.pub_thumb+'" width="100%" height="100%"/><a href="#" class="remove"></a>');
			
			$(item_ele+' .uid').val(o.id);
            $(item_ele+' .cancel').removeClass('cancel').addClass('remove');
			
			//when remove button is clicked
			$(item_ele+' .remove').click(function(){_this.removeImage(f.id);});
        }
        
    },
    /******  Method to remove uploaded images from untextured model upload   ******************/
    removeImage: function(fid)
	{
		
		//Create an object of the current container
		var ele = this.container+' .item#'+fid;
		
		$(ele).find('.pub_feature').attr('src',''); //remove images
		$(ele).find('.pub_thumb').attr('src',''); //remove images
		$(ele).find('.uid').attr('value',''); //set uid value to nothing
		$(ele).removeClass('ui-sortable-handle').addClass('empty ').addClass('ui-sortable-handle')//make container empty to accept new image
		$(ele+' .b3').html('');//empty images
		$(ele).attr('id', 'poslock-1');	//Lock position for new upload on current element so new image is loaded here

	},
	/*****************************************************************************************/
    
    
});






        

var kpiu = kimgupl.extend({
    
    
    uploadSuccess : function(u, f, r) {
        var o = $.parseJSON(r.response);
        
        if(o.success) {
            var item_ele = this.container+' .item#'+f.id;
            $(item_ele+' .progress').hide();
            $(item_ele+' .percent').hide();
			//Commented code to display images after successful upload with new one that have remove button
            //$(item_ele+' .img').html('<a class="cancel"></a><img class="pub_feature" src="'+o.sizes.pub_feature+'" width="100%" height="100%" /><img class="pub_thumb" src="'+o.sizes.pub_thumb+'" width="100%" height="100%" />');
            
			//New code with remove button
			$(item_ele+' .b3').html('<a class="cancel"></a><img class="pub_feature" src="'+o.sizes.pub_feature+'" width="100%" height="100%" /><img class="pub_thumb" src="'+o.sizes.pub_thumb+'" width="100%" height="100%"/><a href="#" class="remove"></a>');
			
			$(item_ele+' .uid').val(o.id);
            $(item_ele+' .cancel').removeClass('cancel').addClass('remove');
			
			//when remove button is clicked
			$(item_ele+' .remove').click(function(){_this.removeImage(f.id);});
        }
        
    },
    /******  Method to remove uploaded images from untextured model upload   ******************/
    removeImage: function(fid)
	{
		
		//Create an object of the current container
		var ele = this.container+' .item#'+fid;
		
		$(ele).find('.pub_feature').attr('src',''); //remove images
		$(ele).find('.pub_thumb').attr('src',''); //remove images
		$(ele).find('.uid').attr('value',''); //set uid value to nothing
		$(ele).removeClass('ui-sortable-handle').addClass('empty ').addClass('ui-sortable-handle')//make container empty to accept new image
		$(ele+' .b3').html('');//empty images
		$(ele).attr('id', 'poslock-1');	//Lock position for new upload on current element so new image is loaded here

	},
	/*****************************************************************************************/
    removeFile : function(fid) {
        var item_ele = this.container+' .item#'+fid;
        $(item_ele+' .img').html('');
        $(item_ele+' .uid').val('');
        $(item_ele).addClass('empty').removeAttr('id');
        $(this.container).trigger("onItemRemove");
    } ,
     /******  Method to  handle drag-and-drop interaction  ******************/
    setDragDrop: function(){
		
		var droppableParent;
	
		//Setting DIV element to be draggable
		$('li .b2').draggable({
			revert: 'invalid',
			revertDuration: 200,
			start: function () {
			droppableParent = $(this).parent();
		
			$(this).addClass('being-dragged');
			
		},
		stop: function () {
			$(this).removeClass('being-dragged');
		}
	});
	//Setting where item will be dropped
	$('ul li.item').droppable({
		hoverClass: 'drop-hover',
		//Handling Drop Action
		drop: function (event, ui) {
			//Get Items Being Dragged and Target Container
			var draggable = $(ui.draggable[0]),
				draggableOffset = draggable.offset(),
				container = $(event.target),
				containerOffset = container.offset();
			
			
			var target_idx = $('ul li.item').index(this); //Index for Target Container
			var dragged_idx = $(ui.draggable[0]).parent().index() //Index of Drag Container
			
			//Create instances of both target and dragged elements
			var ele_target = $("ul li.item").get(target_idx);
			if(dragged_idx > 0)//Check if element is the first element
			{
				 ele_dragged = $("ul li.item").get(dragged_idx - 1);
			}
			else
			{
				ele_dragged = $("ul li.item").get(dragged_idx);
			}
			
			//Get ID of each of the target and dragged elements to check if an image has been uploaded
			var id_target = $(ele_target).attr('id');
			var id_dragged = $(ele_dragged).attr('id');

			var pub_feature_target_src =  $(ele_target).find('.pub_feature').attr('src');
			var pub_feature_dragged_src =  $(ele_dragged).find('.pub_feature').attr('src');	

			var pub_thumb_target_src =  $(ele_target).find('.pub_thumb').attr('src');
			var pub_thumb_dragged_src =  $(ele_dragged).find('.pub_thumb').attr('src');		
			
			var uid_target		= $(ele_target).find('.uid').attr('value');
			var uid_dragged		= $(ele_dragged).find('.uid').attr('value');	
						
			//Get class of the target and dragged elements
			var cls_target = $(ele_target).attr('class');
			var cls_dragged = $(ele_dragged).attr('class');
			
			//Check if Target Element is Empty
			if(id_target == '' || id_target == null || id_target == 'undefined' )
			{
				//Check if Dragged Element is Empty
				if(id_dragged == '' || id_dragged == null || id_dragged == 'undefined')
				{
					//Set both element to Empty
					
					//Setting Dragged Element to Empty
					$(ele_dragged).find('.pub_feature').attr('src','');
					$(ele_dragged).find('.pub_thumb').attr('src','');
					$(ele_dragged).find('.uid').attr('value','');
					$(ele_dragged).removeClass('ui-sortable-handle').addClass('empty ').addClass('ui-sortable-handle')
					//$(ele_dragged+' .b3').html('');
					//$(ele_dragged).attr('id', 'poslock-1');
					
					//Setting Target Element to Empty
					$(ele_target).find('.pub_feature').attr('src','');
					$(ele_target).find('.pub_thumb').attr('src','');
					$(ele_target).find('.uid').attr('value','');
					$(ele_target).removeClass('ui-sortable-handle').addClass('empty ').addClass('ui-sortable-handle')
					//$(ele_target+' .b3').html('');
					//$(ele_target).attr('id', 'poslock-1');
				}
				else
				{
					//If only Target Element is Empty then replace Target Element with Dragged Element parameters
					$(ele_target).attr('id',id_dragged);
					//$(ele_target).attr('class',cls_dragged);
					$(ele_target).find('.uid').attr('value',uid_dragged);
					//$(ele_target).attr('class',cls_dragged);
					//$(ele_target).find('.pub_feature').attr('src',pub_feature_dragged_src);
					//$(ele_target).find('.pub_thumb').attr('src',pub_thumb_dragged_src);
					
					if(target_idx == 0)
					{
						$(ele_dragged).find('.pub_feature').attr('style',"display:inline");
						$(ele_dragged).find('.pub_thumb').attr('style',"display:none");
					}
					
					//Setting Dragged Element to Empty
					$(ele_dragged).attr('id', null);
					//$(ele_dragged).find('.pub_feature').attr('src','');
					//$(ele_dragged).find('.pub_thumb').attr('src','');
					$(ele_dragged).find('.uid').attr('value',null);
					$(ele_dragged).removeClass('ui-sortable-handle').addClass('empty ').addClass('ui-sortable-handle')
					//$(ele_dragged+' .b3').html('');
					//$(ele_dragged).attr('id', 'poslock-1');
				}
			}
			else
			{
				//Check to see if Dragged Element is Empty
				if(id_dragged == '' || id_dragged == null || id_dragged == 'undefined')
				{
					//Replace Dragged Element with Target Element parameters
					$(ele_dragged).attr('id',id_target);
					$(ele_dragged).attr('class',cls_target);
					
					//$(ele_dragged).find('.pub_feature').attr('src',pub_feature_target_src);
					//$(ele_dragged).find('.pub_thumb').attr('src',pub_thumb_target_src);
					$(ele_dragged).find('.uid').attr('value',uid_target);
					
					if(dragged_idx == 0)
					{
						$(ele_target).find('.pub_feature').attr('style',"display:inline");
						$(ele_target).find('.pub_thumb').attr('style',"display:none");
					}
						
					
					//Setting Target Element to Empty
					$(ele_target).attr('id', null);
					//$(ele_target).find('.pub_feature').attr('src','');
					//$(ele_target).find('.pub_thumb').attr('src','');
					$(ele_target).find('.uid').attr('value',null);
					$(ele_target).removeClass('ui-sortable-handle').addClass('empty ').addClass('ui-sortable-handle')
					//$(ele_target+' .b3').html('');
					//$(ele_target).attr('id', 'poslock-1');
				}
				else
				{
					//Swapping Element Parameters if Both Contain information
					$(ele_target).attr('id',id_dragged);
					//$(ele_target).find('.pub_feature').attr('src',$(ele_dragged).find('.pub_feature').attr('src'));
					//$(ele_target).find('.pub_thumb').attr('src',$(ele_dragged).find('.pub_thumb').attr('src'));
					$(ele_target).find('.uid').attr('value',$(ele_dragged).find('.uid').attr('src'));
					//$(ele_target).removeClass('ui-sortable-handle').addClass('empty ').addClass('ui-sortable-handle')
					//$(ele_target).find('.b3').html($(ele_dragged).find('.b3').html());
					//$(ele_target).attr('id', 'poslock-1');
					$(ele_target).attr('class',$(ele_dragged).attr('class'));
					if(target_idx == 0)
					{
						$(ele_dragged).find('.pub_feature').attr('style',"display:inline");
						$(ele_dragged).find('.pub_thumb').attr('style',"display:none");
					}
					
					$(ele_dragged).attr('id',id_target);
					//$(ele_dragged).find('.pub_feature').attr('src',$(ele_target).find('.pub_feature').attr('src'));
					//$(ele_dragged).find('.pub_thumb').attr('src',$(ele_target).find('.pub_thumb').attr('src'));
					$(ele_dragged).find('.uid').attr('value',$(ele_target).find('.uid').attr('src'));
					//$(ele_target).removeClass('ui-sortable-handle').addClass('empty ').addClass('ui-sortable-handle')
					//$(ele_dragged).find('.b3').html($(ele_target).find('.b3').html());
					//$(ele_target).attr('id', 'poslock-1');
					$(ele_dragged).attr('class',$(ele_target).attr('class'));
					if(dragged_idx == 0)
					{
						$(ele_target).find('.pub_feature').attr('style',"display:inline");
						$(ele_target).find('.pub_thumb').attr('style',"display:none");
					}					
				}
			}

			
			//Check to see if there is an interaction with the large featured item
			if($('ul li.item').index(this) == 0)
			{
				//Drop the element and resize accordingly
				$('.b2', event.target).appendTo(droppableParent).css({opacity: 0, width:125,height:90}).animate({opacity: 1}, 200);
				draggable.appendTo(container).css({left: draggableOffset.left - containerOffset.left, top: draggableOffset.top - containerOffset.top,width:198,height:136}).animate({left: 0, top: 0}, 50);
				
			}
			else
			{
				//Check if the dragged item is the large featured item
				if($(ui.draggable[0]).parent().index() == 0)
				{
					//Drop the elements and resize accordingly to fit placeholder
					$('.b2', event.target).appendTo(droppableParent).css({opacity: 0, width:198,height:136}).animate({opacity: 1}, 200);
					draggable.appendTo(container).css({left: draggableOffset.left - containerOffset.left, top: draggableOffset.top - containerOffset.top,width:125,height:90}).animate({left: 0, top: 0}, 50);
				}
				else
				{
					//Drop elements, no re-sizing required
					$('.b2', event.target).appendTo(droppableParent).css({opacity: 0}).animate({opacity: 1}, 200);
					draggable.appendTo(container).css({left: draggableOffset.left - containerOffset.left, top: draggableOffset.top - containerOffset.top}).animate({left: 0, top: 0}, 50);

				}
			}
			
			var ictr = 0;
			
			var ele_position_set = $("ul li.item").get(ictr);
			while(ele_position_set != null)
			{
				var id_ele_position_set = $(ele_position_set).attr('id');
				if(id_ele_position_set == null)
				{
					$(id_ele_position_set).attr('id', 'poslock-1');
					return;
				}
				ictr++;
				var ele_position_set = $("ul li.item").get(ictr);
			}
				
			
		}
	});
	},
    // Commenting out old setSort Function - Not Required
	// *************************************************
	/*setSort : function() {
                this.is_dragging_first = true;
        
        var _this = this;
        
        $(this.container+' .items').sortable({
            cancel:"li.secsep, li.poslock",
            cursor: "move",
            opacity: 0.5,
            scroll : false,
            placeholder  : 'sortable-placeholder',
            change:function(event,ui) {
                
                
                
                
                $(_this.container+' .items .poslock').each(function() {
                    var secsep_num = parseInt($(this).attr('id').split('-')[1]);
                    
                    var thisindex = $(ui.helper).index();
                     var fixed = $("#poslock-"+secsep_num);           
                     var index = fixed.index();
                     var targetindex = secsep_num+1;
                     
                     if(index !== targetindex) {         
                         if(index > targetindex ) {
                             fixed.prev().insertAfter(fixed).trigger('domup'); //move it up by one position
                         } else if(index==(targetindex-1) && thisindex>targetindex) {
                             //don't move it at all
                         } else {
                             fixed.next().insertBefore(fixed).trigger('domdown'); //move it down by one position
                         }
                     } else if(index==targetindex && thisindex>targetindex) {
                         fixed.prev().insertAfter(fixed).trigger('domup'); //move it up by one position
                     }
                    
                });
                
                
                
                if(_this.is_dragging_first) {
                    if($(ui.placeholder).index() > 1) {
                        $(ui.placeholder).removeClass('first');
                        $($('.items .item').not('.ui-sortable-helper').get(0)).addClass('first');
                    }
 
                }
                
                
             },
 
             start : function(event, ui) {
                 if($(ui.helper).index() == 0) {
                     _this.is_dragging_first =  true;
                      $(ui.placeholder).addClass('first');
                 } else {
                     _this.is_dragging_first =  false;
 
 
                 }
             },
             
             stop : function(event, ui) {
                 _this.setPreviewSize();
                 _this.is_dragging_first =  false;
                 $('.items .item').removeClass('first');
             },
             
             
             
         });*/
       /* var _this = this;
        
        $(_this.container+' ul li .inner').draggable({
            scroll: false,
            opacity: 0.5,
            stop : function(event, ui) {
                
                $(_this.container+' ul li .inner')
                .removeClass('dswitch')
                .removeClass('moved_inner').css({left : 0, top : 0});
            }
        });
        
        $( _this.container+' ul li' ).droppable({
            
            drop: function( event, ui ) {
                
                var drop_container = $(event.target);
                var drop_container_element = drop_container.find('.inner');
                var drop_list_section = drop_container.closest('.section');
                
                var drag_element = $(ui.draggable);
                var drag_element_container = drag_element.closest('li');
                var drag_list_section = drag_element_container.closest('.section');
                
                $(drop_container).removeClass('dragenter');
                if(drop_list_section.index() === drag_list_section.index() && drop_container.index() === drag_element_container.index()) {
                    
                    
                } else {
                    drop_container.removeClass('dragenter').removeClass('empty');
                    
                    //is drag container empty
                    
                    drag_element.addClass('moved_inner');
                    drop_container_element.addClass('dswitch');

                    $(drop_container).append(drag_element);
                    drag_element_container.append($(drop_container).find('.inner.dswitch'));
                    
                    if(drag_element_container.find('.uid').val() == "") {
                        drag_element_container.addClass('empty')
                    }
                    
                }
                
                
            },
            
            over : function (event, ui) {
              var drop_container = $(event.target);
              $(drop_container).addClass('dragenter');
            },

            out : function(event, ui) {
              var drop_container = $(event.target);
              $(drop_container).removeClass('dragenter');
            }
        });*/
    //} , 
    
    
    
    setDropzone : function() {
        
        var _this = this;
        
        $(this.drop_element).each(function() {
            var _ele = this;
            var dropzone = new mOxie.FileDrop({
                drop_zone: $(_ele).find('.b3').get(0)
            });
            dropzone.ondrop = function( event ) {
                $(_ele).removeClass('dragenter');
                _this.PLU.addFile( dropzone.files );
            };
            dropzone.ondragenter = function(event) {
                $(_ele).addClass('dragenter');
            };
            dropzone.ondragleave = function(event) {
                $(_ele).removeClass('dragenter');
            };
            dropzone.init();
        });
    }
    
});





var kpfu = ks3uplr.extend({
    
    
    
    
    
    
});




/*
var ks3imgupl = ks3uplr.extend({
    
    //init : function(params) {
//        this._super(params);
//    } ,
    
    setDropzone : function() {
        
        var _this = this;
        
        $(this.drop_element).each(function() {
            var _ele = this;
            var dropzone = new mOxie.FileDrop({
                drop_zone: $(_ele).find('.b3').get(0)
            });
            dropzone.ondrop = function( event ) {
                $(_ele).removeClass('dragenter');
                
                console.log(dropzone.files);
                
                _this.PLU.addFile( dropzone.files );
            };
            dropzone.ondragenter = function(event) {
                $(_ele).addClass('dragenter');
            };
            dropzone.ondragleave = function(event) {
                $(_ele).removeClass('dragenter');
            };
            dropzone.init();
        });
    } ,
    
    
    queue_error_file : function(err) {
        
    },
    
    
    queue_file : function(file) {
        
        _this = this;
            $ele = $($(this.container+ ' .item.empty').get(0));
        var preloader = new o.Image();
        
        preloader.onload = function() {
            //preloader.downsize( 300, 300 );
            
            
                        // embed the actual thumbnail
                        console.log(this);
                           
            
            //image.prop( "src", preloader.getAsDataURL() );
        };
        
        preloader.onresize = function() {
            console.log(preloader.getAsDataURL());
            preloader.destroy();
                        
 
        };
        
        preloader.load( file.getSource() );
            
        //console.log(file.getSource());
            
            
            
            
            
            //console.log($ele);
            
            //_this.params.error_ele = '.add_post .error';
            //$(_this.params.error_ele).html('').hide();


            $ele.attr('id', file.id)
                    .removeClass('empty')
                    .find('.progress').show();
            $ele.find('.cancel').show();
            $ele.find('.cancel').click(function() {
                _this.PLU.removeFile(file);
                $(this).closest('li.item').addClass('empty');
                $(_this.container).trigger( "onItemRemove" );
            });
            
            
            
            
            //$($ele).insertBefore(_this.params.container+' .items li.clr');
            //$(_this.params.container).trigger( "onItemAdded" )
    } ,
        
        
        
        
    })
    
    */



/*
ks3uplr.prototype = {
    
    queue_error_file : function(error) {
        var file = error.file;
        var $ele = $('<li id="'+file.id+'" class="file file_error">\
                <div class="progress"></div>\
                <div class="row">\
                    <div class="filename-col">\
                        <span class="filename">'+s3_trancateTitle(file.name)+'</span>\
                        <span class="size">('+s3_format_time(file.size)+')</span>\
                        <span class="error_msg">'+error.message+'</span>\
                    </div>\
                </div>\
            </li>');
        $($ele).insertBefore(_this.params.container+' .items li.clr');
        setTimeout(function(){
            this.remove(file.id);
        }, 3000)
    } ,
    
    queue_file : function(file) {
        var $ele = $('<li id="'+file.id+'" class="file">\
                <div class="progress"></div>\
                <div class="row">\
                    <div class="filename-col">\
                        <span class="filename">'+s3_trancateTitle(file.name)+'</span>\
                        <span class="size">('+s3_format_time(file.size)+')</span>\
                        <a class="remove"></a>\
                    </div>\
                </div>\
        </li>');
        
        $ele.find('.remove').click(function() {
            this.PLU.removeFile(file);
            this.remove(file.id);
        })
            
            
        $($ele).insertBefore(this.container+' .items li.clr');
        $(this.container).trigger( "onItemAdded" )
    },
    
    process_queue : function(up, file) {
        this.current_file = file;
        $('#'+file.id+' .progress').width(file.percent+'%');
        $('#'+file.id+' .upload_progress').html(format_time((file.size - file.loaded)/up.total.bytesPerSec));
    },
        
        
    plu_before_upload : function(up, file) {
        up.settings.multipart_params = jQuery.extend(true, {}, this.m_p);
        var k = (this.m_p.key).replace('{id}', file.id);
            
        file.s3Key = k+file.name;
            
        up.settings.multipart_params.key = file.s3Key;
        up.settings.multipart_params.Filename = file.s3Key;
    },
    setComplete : function() {
        this.is_completed = true;
    },
        
    remove : function(id) {
        $(this.container+' .items li#'+id).remove();
        $(this.container).trigger( "onItemRemove" )
    },
        
        
    isFileSizeChunkableOnS3 : function( fileSize ) {
        var minSize = plupload.parseSize(this.chunk_size);
        return( fileSize > minSize );
    },

    uploadSuccess : function(u, f, r) {
        var item = this.container+' .items #'+f.id;
        $(item+ ' .progress').remove();
        $(item+ ' .processing').show();
        $(item+ ' .remove').removeClass('remove').addClass('processing');
            
            
        $.ajax({type : 'POST',url:ksm_settings.ajax_url,data : {action:this.sa, k:f.s3Key},success: function () {
            $(item).append('<input type="hidden" class="s3_file_input" name="attach[]" value="'+f.s3Key+'">');
            $(item+ ' .processing').removeClass('processing').addClass('remove');
        }});
    },
    
    
    
    init : function() {
        
        this.PLU = new plupload.Uploader({
            url : this.url,
            file_data_name : 'file',
            runtimes : 'html5,flash',
            multipart: true,
            multipart_params : {},
            max_file_size: this.max_size,
            max_retries: 2,
            browse_button : $(this.browse_button).get(0),
            container: $(this.container).get(0),
            flash_swf_url : ksm_settings.plu.flash_swf_url,
            urlstream_upload: true,
            multiple_queues : true,
            chunk_size : 0,
            filters : [
                {title : "Files", extensions : this.file_types}
            ],
            
            preinit : {
                Error: function(up, err, a) {
                   if(err.code == plupload.FILE_SIZE_ERROR || err.code == plupload.FILE_EXTENSION_ERROR) {
                        this.queue_error_file(err);
                   } else if(err.code == plupload.HTTP_ERROR) {
                       $(this.container+ ' .items #'+err.file.id)
                                .addClass('file_error')
                                .find('.message-col').html('<span class="error_note">'+err.message+'</span>');
                   }
		}
            },
            
            init: {
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        this.queue_file(file);
                    });
                    if(this.PLU.state != plupload.UPLOADING) {
                        this.PLU.start();
                    }
		},

		UploadProgress : function(up, file) {this.process_queue(up, file);},
                FileUploaded : function(up, file, res) { this.uploadSuccess(up, file, res);},
                BeforeUpload : function(up, file) {this.plu_before_upload(up, file)},
                ChunkUploaded : function(uploader, file, info) {this.chunkUploaded(uploader, file, info)},

		StateChanged : function(up) {
                    //if(up.state == plupload.STOPPED && _this.params.PLU.total.queued > 0){
                    //    up.start()
                    //}
                },
                
                UploadComplete : function(up, s) {this.setComplete();}
                
            }
        });
        
        this.PLU.init();
    }
    
    
}


*/

//////////////////////////////////////////////////////////


/*
var s3_uploader = function(params) {
    
    //'use strict';
    
    var _this = this;
    
    var defaults = {
	files : new Array(),
        PLU : null,
        is_completed : true,
        num_errors : 0,
        current_file : null,
        
        inlineStatus : null,
        m_p : {},
        url : '',
        max_size : '50mb',
        file_types : '*',
        max_files : 0,
        chunk_size : '5mb'
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
        
        
    
    
        _this.params.max_files = parseInt(_this.params.max_files);

        _this.process_queue = function(up, file) {
            

            _this.params.current_file = file;
            jQuery('#'+file.id+' .progress').width(file.percent+'%');
            
            jQuery('#'+file.id+' .upload_progress').html(format_time((file.size - file.loaded)/up.total.bytesPerSec));
            
            
            
            
        }
        
        
        
        _this.queue_error_file = function(error) {
            var file = error.file;
            
            var $ele = $('<li id="'+file.id+'" class="file file_error">\
                <div class="progress"></div>\
                <div class="row">\
                    <div class="filename-col">\
                        <span class="filename">'+s3_trancateTitle(file.name)+'</span>\
                        <span class="size">('+s3_format_time(file.size)+')</span>\
                        <span class="error_msg">'+error.message+'</span>\
                    </div>\
                </div>\
            </li>');
            
            

            $($ele).insertBefore(_this.params.container+' .items li.clr');
            
            setTimeout(function(){
                _this.remove(file.id);
            }, 3000)
        }
        
        


        _this.queue_file = function(file) {
            
            
            var $ele = $('<li id="'+file.id+'" class="file">\
                <div class="progress"></div>\
                <div class="row">\
                    <div class="filename-col">\
                        <span class="filename">'+s3_trancateTitle(file.name)+'</span>\
                        <span class="size">('+s3_format_time(file.size)+')</span>\
                        <a class="remove"></a>\
                    </div>\
                </div>\
            </li>');
            
            
            
            $ele.find('.remove').click(function() {
                //console.log()
                _this.params.PLU.removeFile(file);
                _this.remove(file.id);
            })
            
            
            $($ele).insertBefore(_this.params.container+' .items li.clr');
            $(_this.params.container).trigger( "onItemAdded" )
            
            
        }
        
        _this.remove = function(id) {
            $(_this.params.container+' .items li#'+id).remove();
            $(_this.params.container).trigger( "onItemRemove" )
        }
        
        
        _this.isFileSizeChunkableOnS3 = function( fileSize ) {
            var minSize = plupload.parseSize(_this.params.chunk_size);
            return( fileSize > minSize );
         }

        _this.uploadSuccess = function(u, f, r) {
            var item = _this.params.container+' .items #'+f.id;
            $(item+ ' .progress').remove();
            $(item+ ' .processing').show();
            $(item+ ' .remove').removeClass('remove').addClass('processing');
            
            
            $.ajax({type : 'POST',url:ksm_settings.ajax_url,data : {action:_this.params.sa, k:f.s3Key},success: function () {
                $(item).append('<input type="hidden" class="s3_file_input" name="attach[]" value="'+f.s3Key+'">');
                $(item+ ' .processing').removeClass('processing').addClass('remove');
            }});
            
            
        }
        
        
        
    
        _this.plu_before_upload = function(up, file) {
            up.settings.multipart_params = jQuery.extend(true, {}, _this.params.m_p);
            var k = (_this.params.m_p.key).replace('{id}', file.id);
            
            
            file.s3Key = k+file.name;
            
            up.settings.multipart_params.key = file.s3Key;
            up.settings.multipart_params.Filename = file.s3Key;
            
        }
    
        
        
        
        _this.setComplete = function() {
            _this.params.is_completed = true;
        }
    
    _this.init = function() {
        
        
        
        
        _this.params.PLU = new plupload.Uploader({
            url : _this.params.url,
            file_data_name : 'file',
            runtimes : 'html5,flash',
            multipart: true,
            multipart_params : {},
            max_file_size: _this.params.max_size,
            max_retries: 2,
            browse_button : $(_this.params.browse_button).get(0),
            container: $(_this.params.container).get(0),
            flash_swf_url : ksm_settings.plu.flash_swf_url,
            urlstream_upload: true,
            multiple_queues : true,
            chunk_size : 0,
            filters : [
                {title : "Files", extensions : _this.params.file_types}
            ],
            
            preinit : {
                
                Error: function(up, err, a) {
                    //console.log(err);
                   if(err.code == plupload.FILE_SIZE_ERROR || err.code == plupload.FILE_EXTENSION_ERROR) {
                        _this.queue_error_file(err);
                   } else if(err.code == plupload.HTTP_ERROR) {
                        $(_this.params.container+ ' .items #'+err.file.id)
                                .addClass('file_error')
                                .find('.message-col').html('<span class="error_note">'+err.message+'</span>');
                        
                        
                   }
		}
                
            },
            
            init: {
                FilesAdded: function(up, files) {
                        
			plupload.each(files, function(file) {
                            _this.queue_file(file)
			});
                        
                        if(_this.params.PLU.state != plupload.UPLOADING) {
                            _this.params.PLU.start();
                        }
		},

		UploadProgress : function(up, file) {_this.process_queue(up, file);},
                FileUploaded : function(up, file, res) { _this.uploadSuccess(up, file, res);},
                BeforeUpload : function(up, file) {_this.plu_before_upload(up, file)},
                ChunkUploaded : function(uploader, file, info) {_this.chunkUploaded(uploader, file, info)},

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



*/


$(function() {
    $('.browse_btn').click(function(e) {
        e.preventDefault();
    })
})