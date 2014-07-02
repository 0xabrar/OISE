$(document).ready(function(){
    //sortable list
    $('#sortable').sortable({
        axis: 'y',
        //updates of list order sent to php script to update database
        update: function (event, ui) { 
            sendListOrder();
        }
    });
    
    $("#theform").submit(function() {
        if (checkFormComplete() === false) { // Check if form is complete
            alert("Incomplete form!");
            e.preventDefault();
        }else{
            var url = "phpScript.php"; 
            var sID= $("input[name='sid']").val(); 
            var jobID = $("input[name='jobid']").val(); 
            var facultyRank = Math.ceil(Math.random()*10); //random number assigned for facultyRank 
            var data = {'sid':sID, 'jobid':jobID, 'facultyRank':facultyRank}; //data to be sent
            
            $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: 'json', 
                    success: function(data) //success function with data in json form
                    {
                        removeRanking(); //remove previous list 
                        displayRanking(data.jobIDs, data.appIDs); //display new list
                    }
            });
    
            return false; // avoid to execute the actual submit of the form.
        }
    });
    
    $('#bttn').click(function(){        
        sendListOrder();
    });
    
    //updates of list order sent to php script to update database
    function sendListOrder() {
        var data = $('#sortable').sortable('serialize'); //serialize list 
        $.ajax({
            data: data,
            type: 'POST',
            url: 'updateSortable.php'
        });   
    }
    
    //remove previous list
    function removeRanking() { 
        $('#sortable').empty();
    }
    //display new sortable list
    function displayRanking(jobIDs, appIDs){
        //loop through all jobIDs of current sID and add to sortable list 
        $.each(jobIDs, function(index, element) {
            //give new list element the current jobID and id= item_(appID)
            var $li = $("<li class='ui-state-default' id='item_"+ appIDs[index] +"'/>").text(element);
            $("#sortable").append($li);
            $("#sortable").sortable('refresh');
        });
    }
    //returns false if incomplete form
    function checkFormComplete() {
        var isValid = true;
        //loops through each form input type to see if empty
        $('input[type="text"]').each(function() {
            if ($.trim($(this).val()) == '') {
            isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE"
                });
            }
            else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });
        return isValid; 
    }
});