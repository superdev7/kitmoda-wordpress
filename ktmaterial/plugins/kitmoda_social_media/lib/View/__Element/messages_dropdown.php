<div class="ddlist_messages_positioner">
    <div class="ddlist" name="Message_dd">
        <div class="edge"><div class="inner"></div></div>
        <div class="box">
            <div class="header">
                <div class="title">Messages</div>
                <div class="options">
                    <a href="<?=ksm_get_permalink("message/compose/")?>" class="btn_new_msg colorbox"></a>
                    <ul>
                        <li class="read_bulk" action="Message_read"></li>
                        <li class="delete_bulk" action="Message_delete"></li>
                        <li class="checkbox_bulk">
                            <input type="checkbox" />
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="list"></ul>
            <div class="empty"></div>
            <?php include 'loading.php'; ?>
            <div class="footer">
                <div class="pagination">
                    <a href="" class="prev"></a>
                    <span class="info"></span>
                    <a href="" class="next"></a>
                </div>
            </div>
        </div>
    </div>
</div>