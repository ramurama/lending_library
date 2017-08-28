g_memberlist = new Array, g_selectedmember = new Array;
g_booklist = new Array, g_selectedbooks = new Array, g_bookkey = new Array;
g_op_msg = '';
function member_search(){
    //$("#loader").show();  
    var searchField = $('#search_member').val();
    if(searchField.length>=1){
        $.ajax({
            type: "POST",
            url: "services/common_services.php", // 
            data: "searchField="+searchField+"&action=search_member", 
            success: function(result){
                result = JSON.parse(result);
                if(result.infocode == 'SEARCHED'){
                    g_memberlist.length = 0;
                    var d=result.data;
                    var output = '';
                    for(var x=0;x<(d.length);x++) {
                        output+='<input type="text" value="'+d[x].member_name+' '+d[x].phone_number+'" onclick="setmemberid('+d[x].member_id+');" style="cursor:pointer;" class="textbox"/><br/>';
                        var temp = new Array;
                        temp.member_name = d[x].member_name;
                        temp.phone_number = d[x].phone_number;
                        temp.member_id = d[x].member_id;
                        temp.member_credit = d[x].member_credit;
                        g_memberlist[d[x].member_id] = temp;
                    }
                    if(d.length>4){
                        $("#autoselect_member").addClass('container');
                    } else{
                        $("#autoselect_member").removeClass('container');
                    }
                    //alert(output);
                    $('#autoselect_member').html(output);
                }else if(result.infocode=='NODATAFOUND'){
                    $('#autoselect_member').html("Members Not Found");
                    $("#autoselect_member").removeClass('container');
                } 
                $("#loader").hide();        
            }
        });
    } else {
        $('#autoselect_member').html("");
        $("#autoselect_member").removeClass('container');
        $("#loader").hide();  
    } 
}

function book_search(){
    //$("#loader").show();  
    var searchField = $('#search_book').val();
    if(searchField.length>=1){
        $.ajax({
            type: "POST",
            url: "services/common_services.php", // 
            data: "searchField="+searchField+"&action=search_book", 
            success: function(result){
                result = JSON.parse(result);
                if(result.infocode == 'SEARCHED'){
                    g_booklist.length = 0;
                    var d=result.data;
                    var output = '';
                    for(var x=0;x<(d.length);x++) {
                        output+='<input type="text" value="'+d[x].book_id+ ' '+d[x].book_name+' '+d[x].old_number+'" onclick="setbook(\''+d[x].book_language+'_'+d[x].book_id+'\');" style="cursor:pointer;width:300px;" class="textbox"/><br/>';
                        var temp = new Array;
                        temp.book_name = d[x].book_name;
                        temp.book_language = d[x].book_language;
                        temp.book_id = d[x].book_id;
                        temp.author_name = d[x].author_name;
                        temp.book_rate = d[x].book_rate;
                        temp.book_category = d[x].book_category;
                        key = d[x].book_language+'_'+d[x].book_id
                        g_booklist[key] = temp;
                    }
                    if(d.length>4){
                        $("#autoselect_book").addClass('container');
                    } else{
                        $("#autoselect_book").removeClass('container');
                    }
                    //alert(output);
                    $('#autoselect_book').html(output);
                }else if(result.infocode=='NODATAFOUND'){
                    $('#autoselect_book').html("Books Not Found");
                    $("#autoselect_book").removeClass('container');
                } 
                $("#loader").hide();        
            }
        });
    } else {
        $('#autoselect_book').html("");
        $("#autoselect_book").removeClass('container');
        $("#loader").hide();  
    } 
}

function setmemberid(member_id){
    $('#autoselect_member').html("");
    $("#autoselect_member").removeClass('container');
    g_selectedmember = g_memberlist[member_id];
    memid_display = String("0000" + member_id).slice(-4);
    $('#member_name_span').html('Selected member : '+ memid_display + ' ' + g_selectedmember.member_name + ' ' + g_selectedmember.phone_number);
    $('#member_credit').val(g_selectedmember.member_credit);
    $('#selected_member_id').val(member_id);
}

function setbook(book_id){
    $('#autoselect_book').html("");
    $("#autoselect_book").removeClass('container');
    isbookavailable(book_id);
    /*if(isbookavailable(book_id)){
        //check_book_taken(book_id);
        g_selectedbooks.push(g_booklist[book_id]);
        display_books();
    }else{
        bootbox.alert(g_op_msg);
        g_op_msg = ''
    }*/
}

function display_books () {
    var dp ='';total_amount = 0;g_bookkey.length = 0;
    template = '<tr ><td>[bookid]</td><td>[bookname]</td><td>[authorname]</td><td>[rate]</td><td>[lendingrate]</td><td>[lendingdate]</td><td>[duedate]</td><td>[action]</td>[bookkey] [bookid_hidden] [booklang_hidden] [bookcat_hidden]</tr>';
    for(c=0;c<g_selectedbooks.length;c++){
        key = g_selectedbooks[c].book_language+'_'+g_selectedbooks[c].book_id;
        g_bookkey[c] = key;
        lr = 0;
        if(g_selectedbooks[c].book_rate != 0){
            //lr = parseFloat(g_selectedbooks[c].book_rate) * 0.1;
            lr = parseFloat(g_selectedbooks[c].book_rate) * g_config_lendingrate[g_selectedbooks[c].book_language][g_selectedbooks[c].book_category];
            lr = Math.round(lr);
        }
        total_amount += lr;
        ld = returnModDate(0);
        //duedate = (g_selectedbooks[c].book_language == 'tamil')?returnModDate(5):returnModDate(7);
        duedate = returnModDate(g_config_lendingdays[g_selectedbooks[c].book_language][g_selectedbooks[c].book_category]);
        dp += template.replace('[bookid]',g_selectedbooks[c].book_id)
                        .replace('[bookname]',g_selectedbooks[c].book_name+'<br><input type="text" value="" placeholder="Remarks" id="remarks_'+key+'" name="remarks_'+key+'" style="width:150px">')
                        .replace('[authorname]',g_selectedbooks[c].author_name)
                        .replace('[rate]','<input type="text" value="'+g_selectedbooks[c].book_rate+'" id="bookrate_'+key+'" name="bookrate_'+key+'" style="width:80px" onkeyup="calculate_lending(\''+key+'\');"><button type="button" class="btn btn-info" onclick="update_bookrate(\''+key+'\', \''+c+'\');"><i class="fa fa-pencil"></i></button>')
                        .replace('[lendingrate]','<input type="text" value="'+lr+'" id="lendingrate_'+key+'" name="lendingrate_'+key+'" style="width:80px">')
                        .replace('[lendingdate]','<input type="text"class="datepick" value="'+ld+'" id="lendingdate_'+key+'" name="lendingdate_'+key+'" style="width:150px">')
                        .replace('[duedate]','<input type="text" class="datepick" value="'+duedate+'" id="duedate_'+key+'" name="duedate_'+key+'" style="width:150px">')
                        .replace('[action]','<button type="button" class="btn btn-danger" onclick="removebook(\''+c+'\');"><i class="fa fa-close"></i></button>')
                        .replace('[bookkey]','<input type="hidden" name="book_key[]" value="'+key+'"/>')
                        .replace('[bookid_hidden]','<input type="hidden" name="bookid_'+key+'" id="bookid_'+key+'" value="'+g_selectedbooks[c].book_id+'"/>')
                        .replace('[booklang_hidden]','<input type="hidden" name="booklang_'+key+'" id="booklang_'+key+'" value="'+g_selectedbooks[c].book_language+'"/>')
                        .replace('[bookcat_hidden]','<input type="hidden" name="bookcat_'+key+'" id="bookcat_'+key+'" value="'+g_selectedbooks[c].book_category+'"/>')
    }
    $('#tbody_selectedbooks').html(dp);
    $('#total_amount').val(total_amount);
    $('.datepick').datepicker({
        todayHighlight: 1,
        autoclose: 1,
        format: 'yyyy-mm-dd',
    });
    calcBalance();
}

function calcBalance(){
    member_credit = $('#member_credit').val().trim();
    advance = $('#advance_amount').val().trim();
    total_amount = $('#total_amount').val().trim();
    balance = 0;
    if(!isNaN(advance)){
        balance = parseInt(member_credit) + parseInt(advance) - parseInt(total_amount);
        $('#balance_amount').val(balance);
    }
}

function returnModDate(days){
    var someDate = new Date();
    var numberOfDaysToAdd = days;
    if(days){
        someDate.setDate(someDate.getDate() + days);
    }

    var dd = someDate.getDate();
    var mm = someDate.getMonth() + 1;
    var y = someDate.getFullYear();
    if(dd < 10) dd = '0'+dd;
    var someFormattedDate = y + '-'+ mm + '-'+ dd; 

    return someFormattedDate;
}

function lend_book_process(){
    var data = $('#lendbook_form').serialize();
    $.ajax({
        type: "POST",
        url: "services/lendbook_services.php", // 
        data: data, 
        success: function(result){
            result = JSON.parse(result);
            if(result.infocode == 'LENDBOOKSUCCESS' || result.infocode == 'LENDBOOKPARTIAL'){
                bootbox.alert(result.message, function(){
                    $('#lendbook_form')[0].reset(); location.reload();
                });
            }else {
                bootbox.alert(result.message);
            } 
        }
    });
}

function removebook(arrayindex){
    bootbox.confirm('You sure you want to delete this book?',function(result){
        if(result){
            g_selectedbooks.splice(arrayindex,1);
            //$('#tr_'+arrayindex).remove();
            display_books();
        }
    });
}

function isbookavailable(book_key){
    //var data = $('#lendbook_form').serialize();
    book_id = g_booklist[book_key].book_id;
    book_language = g_booklist[book_key].book_language;
    book_category = g_booklist[book_key].book_category;
    if(book_category == 'magazine'){
        g_selectedbooks.push(g_booklist[book_key]);
        display_books();
    }else{
        $.ajax({
            type: "POST",
            url: "services/lendbook_services.php", // 
            data: "book_id="+book_id+"&book_language="+book_language+"&action=book_available", 
            async: false,
            success: function(result){
                result = JSON.parse(result);
                if(result.infocode == 'BOOKAVAILABLE'){
                    g_selectedbooks.push(g_booklist[book_key]);
                    display_books();
                }else {
                    bootbox.alert(result.message);
                } 
            }
        });
    }
}

function check_book_taken(book_key){
    //var data = $('#lendbook_form').serialize();
    book_id = g_booklist[book_key].book_id;
    book_language = g_booklist[book_key].book_language;
    $.ajax({
        type: "POST",
        url: "services/lendbook_services.php", // 
        data: "book_id="+book_id+"&book_language="+book_language+"&action=book_available", 
        async: false,
        success: function(result){
            result = JSON.parse(result);
            if(result.infocode == 'BOOKAVAILABLE'){
                g_op_msg = result.message;
                return true;
            }else {
                g_op_msg = result.message;
                return false;
            } 
        }
    });
}

function update_bookrate(book_key, array_key){
    book_rate = $('#bookrate_'+book_key).val();
    book_id = $('#bookid'+book_key).val();
    book_language = $('#booklang_'+book_key).val();
    book_id = g_booklist[book_key].book_id;
    book_language = g_booklist[book_key].book_language;
    $.ajax({
        type: "POST",
        url: "services/lendbook_services.php", // 
        data: "book_id="+book_id+"&book_language="+book_language+"&book_rate="+book_rate+"&action=update_bookrate", 
        success: function(result){
            result = JSON.parse(result);
            if(result.infocode == 'BOOKUPDATED'){
                bootbox.alert(result.message);
                g_selectedbooks[array_key].book_rate = book_rate;
            }else {
               bootbox.alert(result.message);
            } 
        }
    });
}

function calculate_lending(book_key){
    book_rate = $('#bookrate_'+book_key).val();
    book_id = g_booklist[book_key].book_id;
    book_language = g_booklist[book_key].book_language;
    book_category = g_booklist[book_key].book_category;

    if(book_rate != '' && !isNaN(book_rate) && parseInt(book_rate) != 0){
        //lr = parseFloat(g_selectedbooks[c].book_rate) * 0.1;
        lr = parseInt(book_rate) * g_config_lendingrate[book_language][book_category];
        lr = Math.round(lr);
        $('#lendingrate_'+book_key).val(lr);
    }else{
        $('#lendingrate_'+book_key).val(0);
    }
    calculate_total();
}

function calculate_total(){
    total = 0;
    for(i in g_bookkey){
        lending_rate = $('#lendingrate_'+g_bookkey[i]).val();
        total += parseInt(lending_rate);
    }
    $('#total_amount').val(total);
    calcBalance();
}