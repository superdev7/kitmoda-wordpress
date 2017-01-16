<table width="500" border="0" height="184" style="margin-top : 40px">
            <tbody>
                <tr>
                  <td width="166" rowspan="6"><?=$download->the_thumb('purchase_lib_thumb')?></td>
                  <td height="39" colspan="2" style="color:#44b9fc; font-size : 22px;text-transform:uppercase;"><?=$download->post_title?>
                      <div class="price"><?=edd_currency_filter($pd->price)?></div>
                  </td>
                </tr>
                
                
                
                <tr>
                  <td width="94" height="20">Category</td>
                  <td width="226"><?=$download->get_tax_label('category', false)?></td>
                </tr>
                <tr>
                  <td height="20">Keywords</td>
                  <td><?=$download->get_tax_label('keyword', false)?></td>
                </tr>
                <tr>
                  <td height="20">Era</td>
                  <td><?=$download->get_tax_label('era')?></td>
                </tr>
                <tr>
                  <td height="20">style</td>
                  <td><?=$download->get_tax_label('style')?></td>
                </tr>
                <tr>
                  <td height="20">culture</td>
                  <td><?=$download->get_tax_label('culture')?></td>
                </tr>
            </tbody>
        </table>