$(function() {
	$("#uploader").plupload({
		runtimes : 'html5',
		url : uploadurl,
		max_file_size : '2mb',
		headers: { 'X-REQUESTED-WITH':'XMLHttpRequest' },

		multipart: true,
		multipart_params: {
			'log[_csrf_token]': csrftoken
		},
		file_data_name: 'log[logfile]',
		
		preinit: function(up) {
		  up.logMetaAttributes = {};
		  
		  //the purpose of this is to fire before the ui clears its file list, and store any values that were entered
		  //by the user. These will then be repopulated later.
		  up.bind('QueueChanged', function(up) {
        $.each(this.files, function(i, file) {
          up.logMetaAttributes['logName' + file.id] = $('#logName' + file.id).val();
          up.logMetaAttributes['logMapName' + file.id] = $('#logMapName' + file.id).val();
          up.logMetaAttributes['logInfo' + file.id] = $('#'+file.id+' .plupload_file_name .logInfo').html();
        });
      });
		}
	});
	$("#uploader_container").attr('title', ''); //clearing the ui's runtime title
	
	var uploader = $('#uploader').plupload('getUploader');
	
	//this callback must be added after the upload queue is initialized, since it has to be fired after the ui
	//has added its html.
	uploader.bind('QueueChanged', function(up) {
    $.each(this.files, function(i, file) {
      logNameVal = "";
      logMapNameVal = "";
      logInfo = '<span class="status">Ready to Upload</span>';
      if(up.logMetaAttributes['logName' + file.id]) {
        logNameVal = ' value="'+up.logMetaAttributes['logName' + file.id]+'"';
      }
      if(up.logMetaAttributes['logMapName' + file.id]) {
        logMapNameVal = ' value="'+up.logMetaAttributes['logMapName' + file.id]+'"';
      }
      if(up.logMetaAttributes['logInfo' + file.id]) {
        logInfo = up.logMetaAttributes['logInfo' + file.id];
      }
      
	    $('#'+file.id+' .plupload_file_name').append(
	      '<div class="logMetaData ui-priority-secondary">' +
		    '<label for="logName' + file.id + '">Log Name:</label> <input type="text" id="logName' + file.id + '" class="ui-widget-content ui-corner-all"'+logNameVal+'/>' +
		    '<label for="logMapName' + file.id + '">Map Name:</label> <input type="text" id="logMapName' + file.id + '" class="log_map_name ui-widget-content ui-corner-all"'+logMapNameVal+'/>' +
	    '</div>');
	    
	    $('#'+file.id+' .plupload_file_name').append('<div class="logInfo ui-priority-secondary">' + logInfo + '</div>');
    });
    up.logMetaAttributes = {};
    $(".log_map_name").autocomplete(ACSource);
  });
	    
  uploader.bind('BeforeUpload', function(up, file) {
    $('#'+file.id+' .plupload_file_name .logInfo .status').html("Uploading...");
    $('#'+file.id+' .plupload_file_name :text').attr('disabled', true);
    up.settings.multipart_params['log[name]'] = $('#logName' + file.id).val();
    up.settings.multipart_params['log[map_name]'] = $('#logMapName' + file.id).val();
  });
  
  uploader.bind('FileUploaded', function(up, file, response) {
    var obj = jQuery.parseJSON(response.response);
    $('#'+file.id+' .plupload_file_name .logInfo').html('<a href="'+obj.url+'" target="_new">View the Log</a>');
  });
  
  uploader.bind('UploadProgress', function(up, file) {
    switch (file.status) {			
			case plupload.FAILED:
				$('#'+file.id+' .plupload_file_name .logInfo .status').html("An Error Occurred.");
				break;

			case plupload.UPLOADING:
			  if(file.percent == 100) {
			    //file has been uploaded, just waiting for response.
				  $('#'+file.id+' .plupload_file_name .logInfo .status').html("Processing...");
				}
				break;
		}
	});
});