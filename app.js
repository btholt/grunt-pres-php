$('#user-submit').click(function(e) {
	addNote();
});

$('#user-text').keyup(function(e) {
	if (e.keyCode === 13) { // enter key
		e.preventDefault();
		addNote();
	}
});

$(document).ready(function() {
	$.ajax({
		type: "GET",
		url: "app.php",
		dataType: 'json',
		success: function(data) {
			for(var i = 0; i < data.notes.length; i++) {
				var note = data.notes[i];
				$('#notes').prepend(renderNote(note.id, note.time, note.text));
			}
		}
	});
});

function renderNote(id,time,text) {
	return '<div class="note"><div class="note-time"><span class="note-id">#' + id + '</span> - ' + time + '</div><div class="note-body">' + text + '</div></div>'

}

function addNote() {
	$.ajax({
		type: "POST",
		url: "app.php",
		data: {
			userInput: $('#user-text').val()
		},
		dataType: 'json',
		success: function(data) {
			$('#user-text').val('');
			$('#notes').prepend(renderNote(data.id, data.time, data.text));
		}
	});
}

