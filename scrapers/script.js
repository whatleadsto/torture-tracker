var runs = 14582;
var runs = 10000;
var totaldone = 0;

function runScrape(){
	for (var i=5000;i<=runs;i++){ 
		makeRequest(i);
	}
}

function makeRequest(tid){
		var data = 'tid=' + tid;
    	$.ajax({
	        type  : 'GET',
	         url  : 'script.php',
	         data : data,
	         error : function() {
	         	 console.log('error-' + tid)
	             makeRequest(tid);
	         },
	         success : function (response) {
	             totaldone ++;
	             checkDone();
	         }
    	});
}

function checkDone(){
	var percent = Math.round((totaldone/runs)*100);
	document.getElementById('percent').innerHTML = percent;
	document.getElementById('done').innerHTML = totaldone;
	document.getElementById('rem').innerHTML = runs-totaldone;
	if(totaldone==runs){
		console.log('--------------------');
		console.log('Scraping complete :)');
		console.log('--------------------');
	}
}