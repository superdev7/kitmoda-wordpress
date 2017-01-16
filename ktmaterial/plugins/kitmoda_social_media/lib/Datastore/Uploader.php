<?php



// "kgdfuh" is file upload handler for all images

// pub_thumb , pub_feature


$data = array(
    
    
    
    
    'cmiu' => array( // collaboration wip message image uploader
        'max_size' => '20mb',
        'max_files' => 6,
        'types' => 'jpg,jpeg,png',
        'container' => '.cmiu_message_form',
        'browse_button' => '.cmiu_message_form .post_img_btn',
        'queue_item' => '<li id="{filekey}" class="item"><div class="percent"></div><div class="progress"><div class="bar"></div></div><div class="preview"><a class="cancel"></a><div class="thumbnail"></div><br class="clear"></div><input type="hidden" name="multi_images[]" class="uid" value=""></li>',
        'obj_name' => 'cmiuobj',
        'action' => 'kgdfuh', 
        'action_type' => 'cmiu',
        'sortable' => true,
        'uploader_class' => 'KSM_Image_Uploader',
        'name' => 'message_attachment',
        'preview_size' => 'thumbnail',
        'js_class' => 'kniu'
    ) , 
    
    
    
    'cwfiu' => array( // collaboration wip feedback image uploader
        'max_size' => '20mb',
        'max_files' => 6,
        'types' => 'jpg,jpeg,png',
        'container' => '.cwip_feedback_form',
        'browse_button' => '.cwip_feedback_form .post_img_btn',
        'queue_item' => '<li id="{filekey}" class="item"><div class="percent"></div><div class="progress"><div class="bar"></div></div><div class="preview"><a class="cancel"></a><div class="thumbnail"></div><br class="clear"></div><input type="hidden" name="multi_images[]" class="uid" value=""></li>',
        'obj_name' => 'cwfiuobj',
        'action' => 'kgdfuh', 
        'action_type' => 'cwfiu',
        'sortable' => true,
        'uploader_class' => 'KSM_Image_Uploader',
        'name' => 'cwip_feedback_image',
        'preview_size' => 'thumbnail',
        'js_class' => 'kniu'
    ) , 
    
    
    /*
    
    'ciu' => array( // community post image uploader
        'max_size' => '20mb',
        'max_files' => 6,
        'types' => 'jpg,jpeg,png',
        'container' => '.add_post_form',
        'browse_button' => '.add_post_form .post_img_btn',
        'queue_item' => '<li id="{filekey}" class="item"><div class="percent"></div><div class="progress"><div class="bar"></div></div><div class="preview"><a class="cancel"></a><div class="thumbnail"></div><br class="clear"></div><input type="hidden" name="multi_images[]" class="uid" value=""></li>',
        'obj_name' => 'ciuobj',
        'action' => 'kgdfuh', 
        'action_type' => 'ciu',
        'sortable' => true,
        'uploader_class' => 'KSM_Image_Uploader',
        'name' => 'community_gallery_image',
        'preview_size' => 'thumbnail',
        'js_class' => 'kniu'
    ) , 
    */
    
    
    'postiu' => array( // ksm_post image uploader
        'max_size' => '20mb',
        'max_files' => 12,
        'types' => 'jpg,jpeg,png',
        'container' => '.add_post_form',
        'browse_button' => '.add_post_form .post_img_btn',
        'queue_item' => '<li id="{filekey}" class="item"><div class="percent"></div><div class="progress"><div class="bar"></div></div><div class="preview"><a class="cancel"></a><div class="thumbnail"></div><br class="clear"></div><input type="hidden" name="multi_images[]" class="uid" value=""></li>',
        'obj_name' => 'postiuobj',
        'action' => 'kgdfuh', 
        'action_type' => 'postiu',
        'sortable' => true,
        'uploader_class' => 'KSM_Image_Uploader',
        'name' => 'post_image',
        'preview_size' => 'thumbnail',
        'js_class' => 'kniu'
    ) , 
    
    
    'postiu2' => array( // ksm_post image uploader while editing
        'max_size' => '20mb',
        'max_files' => 12,
        'types' => 'jpg,jpeg,png',
        'container' => '.section.section_images',
        'empty_div' => '.section.section_images .images_empty',
        'browse_button' => '.section.section_images .browse_btn',
        //'queue_item' => '<li id="{filekey}" class="item"><div class="percent"></div><div class="progress"><div class="bar"></div></div><div class="preview"><a class="cancel"></a><div class="thumbnail"></div><br class="clear"></div><input type="hidden" name="multi_images[]" class="uid" value=""></li>',
        'queue_element' => '#poiu_item',
        'obj_name' => 'postiuobj',
        'action' => 'kgdfuh', 
        'action_type' => 'postiu',
        'sortable' => true,
        'uploader_class' => 'KSM_Image_Uploader',
        'name' => 'post_image',
        'preview_size' => 'post_option',
        'js_class' => 'kniu'
    ) , 
    
    
    'epua' => array( // Edit Profile User Avatar Compose Image Uploader
        'max_size' => '20mb',
        'max_files' => 1,
        'types' => 'jpg,jpeg,png',
        'container' => '.avatar_container',
        'browse_button' => '.avatar_container .browse_btn',
        'queue_item' => '<li id="{filekey}" class="item"><div class="percent"></div><div class="progress"><div class="bar"></div></div><div class="preview"><a class="cancel"></a><div class="thumbnail"><img src="" /></div></div><input type="hidden" name="avatar_id" class="uid" value=""></li>',
        'obj_name' => 'epuaobj',
        'action' => 'kgdfuh', 
        'action_type' => 'epua',
        'sortable' => false,
        'uploader_class' => 'KSM_Image_Uploader',
        'name' => 'avatar_attachment',
        'preview_size' => 'thumbnail',
        'js_class' => 'kuaiu'
    ) , 
    
    
    
    
    'mciau' => array( // Message Compose Image Uploader
        'max_size' => '20mb',
        'types' => 'jpg,jpeg,png',
        'container' => '.miu_container',
        'browse_button' => '.miu_container .btn_attach_photo_btn',
        'queue_item' => '<li id="{filekey}" class="item">\
            <div class="progress">\
                <div class="bar"></div>\
            </div>\
            <div class="preview">\
                <a class="cancel"></a>\
                <div class="thumbnail">\
                </div>\
                <br class="clear">\
            </div>\
            <input type="hidden" name="multi_images[]" class="uid" value="">\
            </li>',
        'obj_name' => 'kpiuobj',
        'action' => 'kgdfuh', 
        'action_type' => 'mciau',
        'sortable' => true,
        'uploader_class' => 'KSM_Publisher_Image_Uploader',
        'name' => 'compose_photo_attachment',
        'preview_size' => 'medium',
        'js_class' => 'kniu'
    ) , 
    
    
    
    
    
    
    
   
    
    
    'mcfau' => array( 
        'max_size' => '200mb',
        'types' => '*',
        'container' => '.mau_container',
        'browse_button' => '.mau_container .btn_attachment_btn',
        'queue_item' => '<li class="item" id="{filekey}">\
        <div class="progress">\
            <div class="bar"></div>\
        </div>\
        <div class="row">\
            <a class="cancel"></a>\
            <div class="upload_progress"></div>\
            <div class="filename-col">\
                <span class="filename">{filename}</span>\
                <span class="size"> - {filesize}</span>\
            </div>\
        </div>\
        <input type="hidden" class="uid" name="attach[]" value="">\
    </li>',
        'obj_name' => 'kutpfobj',
        'action' => 'kgdfuh',
        'action_type' => 'mcfau',
        'sortable' => false,
        'uploader_class' => 'KSM_S3_Uploader',
        'name' => 'message_attachment',
        //'max_files' => 1,
        's3' => array(
            'key' => 'ksm/attachments/{un}',
            'acl' => 'private',
            //'Content-Type' => 'application/x-zip-compressed',
            'success_action_params' => array('action' => 'ks3uplsuc')
        )
    ) ,
    
    
    'tpi' => array( // Textured Publisher Image Uploader
        'max_size' => '20mb',
        'types' => 'jpg,jpeg,png',
        'container' => '.images_upl_container',
        'browse_button' => '.images_upl_container .browse_btn',
        'drop_element' => '.images_upl_container .items_container .item',
        'obj_name' => 'kpiuobj',
        'action' => 'kgdfuh',
        'action_type' => 'tpi',
        'sortable' => true,
        'uploader_class' => 'KSM_Publisher_Image_Uploader',
        'name' => 'textured_image',
        'preview_size' => 'pub_thumb, pub_feature',
        'js_class' => 'kpiu'
    ) , 
    
    
    
    'utpi' => array( // Untextured Publisher Image Uploader
        'max_size' => '20mb',
        'types' => 'jpg,jpeg,png',
        'container' => '.images_upl_container',
        'browse_button' => '.images_upl_container .browse_btn',
        'drop_element' => '.images_upl_container .items_container .item',
        'obj_name' => 'kpiuobj',
        'action' => 'kgdfuh',
        'action_type' => 'utpi',
        'sortable' => true,
        'uploader_class' => 'KSM_Publisher_Image_Uploader',
        'name' => 'untextured_image',
        'preview_size' => 'pub_thumb, pub_feature',
        'js_class' => 'kpiu'
    ) , 
    
    
    'acmwpi' => array( // Active Collaboration Model Wip Publisher Image Uploader
        'max_size' => '20mb',
        'types' => 'jpg,jpeg,png',
        'container' => '.images_upl_container',
        'browse_button' => '.images_upl_container .browse_btn',
        'drop_element' => '.images_upl_container .items_container .item',
        'obj_name' => 'kpiuobj',
        'action' => 'kgdfuh',
        'action_type' => 'acmwpi',
        'sortable' => true,
        'uploader_class' => 'KSM_Publisher_Image_Uploader',
        'name' => 'collaboration_model_wip_image',
        'preview_size' => 'pub_thumb, pub_feature',
        'js_class' => 'kpiu'
    ) , 
    
    
    'actwpi' => array( // Active Collaboration Texture Wip Publisher Image Uploader
        'max_size' => '20mb',
        'types' => 'jpg,jpeg,png',
        'container' => '.images_upl_container',
        'browse_button' => '.images_upl_container .browse_btn',
        'drop_element' => '.images_upl_container .items_container .item',
        'obj_name' => 'kpiuobj',
        'action' => 'kgdfuh',
        'action_type' => 'actwpi',
        'sortable' => true,
        'uploader_class' => 'KSM_Publisher_Image_Uploader',
        'name' => 'collaboration_texture_wip_image',
        'preview_size' => 'pub_thumb, pub_feature',
        'js_class' => 'kpiu'
    ) , 
    
    
    
    'capi' => array( // Untextured Publisher Image Uploader
        'max_size' => '20mb',
        'types' => 'jpg,jpeg,png',
        'container' => '.images_upl_container',
        'browse_button' => '.images_upl_container .browse_btn',
        'drop_element' => '.images_upl_container .items_container .item',
        'obj_name' => 'kpiuobj',
        'action' => 'kgdfuh',
        'action_type' => 'capi',
        'sortable' => true,
        'uploader_class' => 'KSM_Publisher_Image_Uploader',
        'name' => 'untextured_image',
        'preview_size' => 'pub_thumb, pub_feature',
        'js_class' => 'kpiu'
    ) , 
    
    
    
    
    
    
    'ucfp' => array( // Untextured Collaboration Publisher Zip Uploader
        'max_size' => '200mb',
        'types' => 'zip',
        'container' => '.file_upl_container',
        'browse_button' => '.file_upl_container .browse_btn',
        'drop_element' => '.file_upl_container .dropbox',
        'empty_div' => '.file_upl_container .dropbox .empty',
        'queue_item' => '<li class="item" id="{filekey}"><div class="progress"><div class="bar"></div></div><div class="row"><div class="filename-col"><span class="filename">{filename}</span><span class="size"> - {filesize}</span></div><div class="status-col"><div class="upload_progress"></div><a class="cancel small-x-button"></a></div><br class="clear"></div><input type="hidden" class="uid" name="ucfp" value=""></li>',
        'obj_name' => 'kutpfobj',
        'action' => 'kgdfuh',
        'action_type' => 'ucfp',
        'sortable' => false,
        'uploader_class' => 'KSM_S3_Uploader',
        'name' => 'untextured_collaboration_file',
        'max_files' => 1,
        's3' => array(
            'key' => 'ksm/untextured_collaboration/{un}',
            'acl' => 'private',
            //'Content-Type' => 'application/x-zip-compressed',
            'success_action_params' => array('action' => 'ks3uplsuc')
        )
    ) ,
    
    
    'tpf' => array( // Textured Publisher Zip Uploader
        'max_size' => '200mb',
        'types' => 'zip',
        'container' => '.textured_file_upl_container',
        'browse_button' => '.textured_file_upl_container .browse_btn',
        'drop_element' => '.textured_file_upl_container .dropbox',
        'empty_div' => '.textured_file_upl_container .dropbox .empty',
        'queue_item' => '<li class="item" id="{filekey}"><div class="progress"><div class="bar"></div></div><div class="row"><div class="filename-col"><span class="filename">{filename}</span><span class="size"> - {filesize}</span></div><div class="status-col"><div class="upload_progress"></div><a class="cancel small-x-button"></a></div><br class="clear"></div><input type="hidden" class="uid" name="tpf" value=""></li>',
        'obj_name' => 'ktpfobj',
        'action' => 'kgdfuh',
        'action_type' => 'tpf',
        'sortable' => false,
        'uploader_class' => 'KSM_S3_Uploader',
        'name' => 'textured_file',
        'max_files' => 1,
        's3' => array(
            'key' => 'ksm/textured/{un}',
            'acl' => 'private',
            //'Content-Type' => 'application/x-zip-compressed',
            'success_action_params' => array('action' => 'ks3uplsuc')
        )
    ) ,
    
    
    
    'utpf' => array( // Untextured Publisher Zip Uploader
        'max_size' => '200mb',
        'types' => 'zip',
        'container' => '.untextured_file_upl_container',
        'browse_button' => '.untextured_file_upl_container .browse_btn',
        'drop_element' => '.untextured_file_upl_container .dropbox',
        'empty_div' => '.untextured_file_upl_container .dropbox .empty',
        'queue_item' => '<li class="item" id="{filekey}"><div class="progress"><div class="bar"></div></div><div class="row"><div class="filename-col"><span class="filename">{filename}</span><span class="size"> - {filesize}</span></div><div class="status-col"><div class="upload_progress"></div><a class="cancel small-x-button"></a></div><br class="clear"></div><input type="hidden" class="uid" name="utpf" value=""></li>',
        'obj_name' => 'kutpfobj',
        'action' => 'kgdfuh',
        'action_type' => 'utpf',
        'sortable' => false,
        'uploader_class' => 'KSM_S3_Uploader',
        'name' => 'untextured_file',
        'max_files' => 1,
        's3' => array(
            'key' => 'ksm/untextured/{un}',
            'acl' => 'private',
            //'Content-Type' => 'application/x-zip-compressed',
            'success_action_params' => array('action' => 'ks3uplsuc')
            
        )
        
    ) ,
    
    
    'ccpi' => array( // Concept Collaboration Image Uploader
        'max_size' => '20mb',
        'types' => 'jpg,jpeg,png',
        'container' => '.images_upl_container',
        'browse_button' => '.browse_btn',
        'drop_element' => '.items_container .item',
        'obj_name' => 'kpiuobj',
        'action' => 'kgdfuh',
        'action_type' => 'ccpi',
        'sortable' => true,
        'uploader_class' => 'KSM_Publisher_Image_Uploader',
        'name' => 'concept_collaboration_image',
        'preview_size' => 'pub_thumb, pub_feature',
        'js_class' => 'kpiu'
    ),
    
    'ucpi' => array( // Untextured Collaboration Image Uploader
        'max_size' => '20mb',
        'types' => 'jpg,jpeg,png',
        'container' => '.images_upl_container',
        'browse_button' => '.browse_btn',
        'drop_element' => '.items_container .item',
        'obj_name' => 'kpiuobj',
        'action' => 'kgdfuh',
        'action_type' => 'ucpi',
        'sortable' => true,
        'uploader_class' => 'KSM_Publisher_Image_Uploader',
        'name' => 'concept_collaboration_image',
        'preview_size' => 'pub_thumb, pub_feature',
        'js_class' => 'kpiu'
    )
    
    
    
    
    
    
);

