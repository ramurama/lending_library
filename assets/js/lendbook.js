g_memberlist = new Array, g_selectedmember = new Array;
g_booklist = new Array, g_selectedbooks = new Array;
function member_search(){
    //$("#loader").show();  
    var searchField = $('#search_member').val();
    if(searchField.length>2){
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
    if(searchField.length>2){
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
                        output+='<input type="text" value="'+d[x].book_name+' '+d[x].book_id+'" onclick="setbook(\''+d[x].book_language+'_'+d[x].book_id+'\');" style="cursor:pointer;" class="textbox"/><br/>';
                        var temp = new Array;
                        temp.book_name = d[x].book_name;
                        temp.book_language = d[x].book_language;
                        temp.book_id = d[x].book_id;
                        temp.author_name = d[x].author_name;
                        temp.book_rate = d[x].book_rate;
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
    $('#member_name_span').html('Selected member : '+ g_selectedmember.member_name + ' ' + g_selectedmember.phone_number);
}

function setbook(book_id){
    $('#autoselect_book').html("");
    $("#autoselect_book").removeClass('container');
    g_selectedbooks.push(g_booklist[book_id]);
    display_books();
}

function display_books () {
    var dp ='';total_amount = 0;
    template = '<tr><td>[bookid]</td><td>[bookname]</td><td>[authorname]</td><td>[rate]</td><td>[lendingrate]</td><td>[lendingdate]</td><td>[duedate]</td><td>[action]</td></tr>';
    for(c=0;c<g_selectedbooks.length;c++){
        key = g_selectedbooks[c].book_language+'_'+g_selectedbooks[c].book_id;
        lr = 0;
        if(g_selectedbooks[c].book_rate != 0){
            lr = parseFloat(g_selectedbooks[c].book_rate) * 0.1;
            lr = Math.round(lr);
        }
        total_amount += lr;
        ld = returnModDate(0);
        duedate = (g_selectedbooks[c].book_language == 'tamil')?returnModDate(5):returnModDate(7);
        dp += template.replace('[bookid]',g_selectedbooks[c].book_id)
                        .replace('[bookname]',g_selectedbooks[c].book_name)
                        .replace('[authorname]',g_selectedbooks[c].author_name)
                        .replace('[rate]','<input type="text" value="'+g_selectedbooks[c].book_rate+'" id="bookrate_'+key+'" name="bookrate_'+key+'" style="width:80px">')
                        .replace('[lendingrate]','<input type="text" value="'+lr+'" id="lendingrate_'+key+'" name="lendingrate_'+key+'" style="width:80px">')
                        .replace('[lendingdate]','<input type="text"class="datepick" value="'+ld+'" id="lendingdate_'+key+'" name="lendingdate_'+key+'" style="width:150px">')
                        .replace('[duedate]','<input type="text" class="datepick" value="'+duedate+'" id="duedate_'+key+'" name="duedate_'+key+'" style="width:150px">')
                        .replace('[action]','<button type="button" class="btn btn-danger" onclick="removebook(\''+key+'\');"><i class="fa fa-close"></i></button>')
    }
    $('#tbody_selectedbooks').html(dp);
    $('#total_amount').val(total_amount);
    $('.datepick').datepicker({
        todayHighlight: 1,
        autoclose: 1,
        format: 'yyyy-mm-dd',
    });
}

function calcBalance(){
    advance = $('#advance_amount').val().trim();
    total_amount = $('#total_amount').val().trim();
    balance = 0;
    if(!isNaN(advance)){
        balance = parseInt(advance) - parseInt(total_amount);
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
    var someFormattedDate = y + '-'+ mm + '-'+ dd; 

    return someFormattedDate;
}