 $(document).ready(function() {
        $('#dataTables-users').dataTable();
        $('#dataTables-storeApiUsers').dataTable();
        $('#dataTables-storeUsers').dataTable();
        $('#dataTables-storeMethod').dataTable();
        $('#dataTables-storeMethodCurrencie').dataTable();
        $('#dataTables-orderItems').dataTable();
        $('#dataTables-orderMethods').dataTable();
        $('#dataTables-errors').dataTable();
        $('#dataTables-phases').dataTable();
        $('#dataTables-storePhase').dataTable({
            "order": [[ 1, "asc" ]]
        });
        $("#StoreUserUserId").select2();
        $("#StoreUserStoreId").select2();
        
        $("#StoreMethodCurrencieMethodId").select2();
        $("#StoreMethodCurrencieCurrencyId").select2();
        $("#StorePhasePhaseId").select2();
        $("#StoreMethodPhaseId").select2();
        $("#StoreUserStoreId").select2();
        $("#MethodUserUserId").select2();
    });
 /*menu handler*/
 $(function(){
   function stripTrailingSlash(str) {
     if(str.substr(-1) == '/') {
       return str.substr(0, str.length - 1);
     }
     return str;
   }

   var currentPage = window.location.href; 
//   var activePage = stripTrailingSlash(url);
   $('.nav li a').each(function(){
//     var currentPage = stripTrailingSlash($(this).attr('href'));
	  var activePage = $(this).attr('href');
     if (activePage == currentPage) {
       $(this).parent().addClass('active'); 
     } 
   });
 });
 
 function imagePreview(element){
	    if($(element)){
	        var win = window.open('', 'preview', 'width=400,height=400,resizable=1,scrollbars=1');
	        win.document.open();
	        win.document.write('<body style="padding:0;margin:0"><img src="'+$(element).src+'" id="image_preview"/></body>');
	        win.document.close();
	        Event.observe(win, 'load', function(){
	            var img = win.document.getElementById('image_preview');
	            win.resizeTo(img.width+40, img.height+80)
	        });
	    }
	    return false;
	}
 function checkCss(obj){
		obj.value = obj.value.replace(/[^a-zA-Z0-9-s]/g,"");
}
 function checkArrayRepeat(array){
		var hash={};
		for(var i in array){
			if(hash[array[i]]){
				return true;
			}
			hash[array[i]]=true;
		}
		return false;
	}
 
 var pgwStore = {
		 setStoreUserLevelHtml:function(storeId){
				console.log(storeId);
				if(storeLevels && storeLevels[storeId] != undefined){
					var level = storeLevels[storeId],
							optionHtml = '';
					for(i=0;i<= level;i++){
						optionHtml += '<option value="'+i+'">'+i+'</option>';
					}
					$("#StoreUserLevel").html(optionHtml);
				}
		 }
 }
 
 var pgwMethod = {
		 setMethodUserLevelHtml:function(methodId){
				console.log(methodLevels);
				if(methodLevels && methodLevels[methodId] != undefined){
					var level = methodLevels[methodId],
							optionHtml = '';
					for(i=0;i<= level;i++){
						optionHtml += '<option value="'+i+'">'+i+'</option>';
					}
					$("#MethodUserLevel").html(optionHtml);
				}
		 }
 }