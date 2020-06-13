const NoteListEntry = (() => {

  const setNoteEditable = (isEditable) => {
    if (isEditable) {
      document.querySelector('.note-content-title').setAttribute("contentEditable", "true");
      document.querySelector('.note-content-desc').setAttribute("contentEditable", "true");

      document.querySelector('.note-content-title').classList.add('editable');
      document.querySelector('.note-content-desc').classList.add('editable');
    } else {
      document.querySelector('.note-content-title').setAttribute("contentEditable", "false");
      document.querySelector('.note-content-desc').setAttribute("contentEditable", "false");
  
      document.querySelector('.note-content-title').classList.remove('editable');
      document.querySelector('.note-content-desc').classList.remove('editable');
    }
  }
  const handleEditClick = (e) => {
    const target = e.target;

    if (target.innerHTML == "Edit") {
      // make note editable
      setNoteEditable(true);
      target.innerHTML = "Done";
    } else {
      // publish edit
      setNoteNoteEditable(false);
      target.innerHTML = "Edit";

      var date = new Date();
      var dateString = date.toDateString() + ' ' + date.toLocaleTimeString();
      document.querySelector('.note-content-date').innerHTML = dateString;
      document.querySelector('.note-content-date-timestamp').innerHTML = date.toISOString().slice(0, 19).replace('T', ' ');

      // Add a form and post to sumbit note edit
      $('<form method="POST" action="editnote">' +
      '<input type="hidden" name="id" value="' + document.querySelector('.note-content-id').innerHTML + '"/>' + 
      '<input type="hidden" name="title" value="' + document.querySelector('.note-content-title').innerHTML + '"/>' + 
      '<input type="hidden" name="content" value="' + document.querySelector('.note-content-desc').innerHTML + '"/>' + 
      '<input type="hidden" name="time" value="' + document.querySelector('.note-content-date-timestamp').innerHTML + '"/>' + 
      '</form>').appendTo("body").submit();
    }
  };

  // add active class
  const handleClick = (e) => {
    const target = e.target;

    document.querySelectorAll('.note-list-entry').forEach((element) => {
      element.classList.remove('active');
    });

    document.querySelectorAll('.note-list-add').forEach((element) => {
      element.classList.remove('active');
    });

    target.classList.add('active');

    // Create new note 
    if (target.classList.contains("note-list-add")) {
      document.querySelector('.note-content').innerHTML = 
      '<div class="note-content-id" hidden>-1</div>' +
      '<div class="note-content-edit">Done</div>' +
      '<div class="note-content-title">New Note</div><br>' +
      '<div class="note-content-date">Last modified: now</div><br>' +
      '<div class="note-content-date-timestamp" hidden></div>' +
      '<div class="note-content-desc">New note ...</div><br>';
      makeNoteEditable();
    } else {
      // Update content
      document.querySelector('.note-content').innerHTML = 
      '<div class="note-content-id" hidden>' + target.querySelector('.note-list-id').innerHTML +'</div>' +
      '<div class="note-content-edit">Edit</div>' +
      '<div class="note-content-title">' + target.querySelector('.note-list-title').innerHTML +'</div><br>' +
      '<div class="note-content-date">Last modified: ' + new Date(target.querySelector('.note-list-date-timestamp').innerHTML).toDateString() + ' ' + new Date(Date.parse(target.querySelector('.note-list-date-timestamp').innerHTML)).toLocaleTimeString() +'</div><br>' +
      '<div class="note-content-date-timestamp" hidden>' + target.querySelector('.note-list-date-timestamp').innerHTML +'</div>' +
      '<div class="note-content-desc">' + target.querySelector('.note-list-desc').innerHTML +'</div><br>';
    }
    // Enable edit button
    document.querySelector('.note-content-edit').addEventListener('click', handleEditClick);

    // hide menu, view content
    document.querySelector('.note-list').classList.add('note-list-hidden')
    document.querySelector('.note-content').classList.remove('note-content-hidden')
  };

  // register events
  const bindEvents = (element) => {
    element.addEventListener('click', handleClick);
  };
  
  // get DOM elements
  const init = () => {
    const entries = document.querySelectorAll('.note-list-list');

    entries.forEach((element) => {
      bindEvents(element);
    });
  };
  
  return {
    init: init
  };

})();
  
NoteListEntry.init();