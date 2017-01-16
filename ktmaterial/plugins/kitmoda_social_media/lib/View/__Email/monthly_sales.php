<div>
    <div style="max-width : 735px;margin:0 auto;">
        <div style="color:#343439;font-size : 26px;margin-top : 30px;">Hi, {{display_name}}! These are your {{month}} sales stats.</div>
        <div style="color:#767680;font-size : 18px;text-align:center">Thank you for being an active seller on Kitmoda.</div>
        
        
        
        <table width="640" border="0" style="margin-top : 45px;margin-bottom : 60px;">
            <tbody>
                <tr>
                    <td width="392">{{month}} SALES TOTAL</td>
                    <td width="238">{{sales_total}}</td>
                </tr>
                <tr>
                    <td>CHANGE FROM PRIOR MONTH</td>
                    <td>{{change}}</td>
                </tr>
                <tr>
                    <td height="40" valign="bottom">YOUR {{month}} EARNINGS</td>
                    <td>{{earning}}</td>
                </tr>
            </tbody>
        </table>



        <table width="900" border="0">
            <tbody>
                <tr>
                    <th colspan="2" scope="col">PRODUCT</th>
                    <th scope="col">PRICE SHARE</th>
                    <th scope="col">SALES</th>
                    <th scope="col">SALES TOTAL</th>
                    <th scope="col">YOUR EARNINGS</th>
                </tr>
                
                
                
                {{foreach items as item}}
                <tr>
                    <td>{{item.thumb}}</td>
                    <td>{{item.title}}</td>
                    <td>{{item.price_share}}</td>
                    <td>{{item.sales}}</td>
                    <td>{{item.sales_total}}</td>
                    <td>{{item.earning}}</td>
                </tr>
                {{endforeach}}
                
            </tbody>
        </table>
        
        
        <div class="details" style="margin-top : 50px; color: #c8c8e1; font-size: 16px;">


            <table width="560" border="0" style="margin-top:40px">
                <tbody>
                    <tr>
                        <td height="30" valign="top">SELLER DETAILS</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size:13px; color:#868697">FULL NAME</td>
                        <td>{{user_full_name}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:13px; color:#868697">EMAIL</td>
                        <td>{{user_email}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:13px; color:#868697">KITMODA USERNAME</td>
                        <td>{{user_login}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <p style="margin-top:80px; text-align:center; font-size : 14px;color:#7f7f99;">By accepting this refund you are agreeing to Kitmoda’s Terms of Use and Copyright Policy.</p>
        
    </div>
</div>