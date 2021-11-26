import $ from "jquery"

class MyNotes {
  // constructor
  constructor() {
    this.events()
  }

  // events
  events() {
    $(".delete-note").on("click", this.deleteNote.bind(this))
    $(".edit-note").on("click", this.editNote.bind(this))
    $(".update-note").on("click", this.updateNote.bind(this))
  }

  // custom methods
  deleteNote(e) {
    const thisNote = $(e.target).parents("li")
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
      },
      url: universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.data("id"),
      type: "DELETE",
      success: response => {
        thisNote.slideUp()
        console.log("Congrats!")
        console.log(response)
      },
      error: error => {
        console.log("sorry")
        console.log(error)
      }
    })
  }

  editNote(e) {
    const thisNote = $(e.target).parents("li")
    if (thisNote.data("state") == "editable") {
      this.makeNoteReadOnly(thisNote)
    } else {
      this.makeNoteEditable(thisNote)
    }
  }

  makeNoteEditable(thisNote) {
    // Once clicked turn into cancel
    thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel')
    // Remove read only attribute
    thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field")
    // Display the update button
    thisNote.find(".update-note").addClass("update-note--visible")
    // Add data state
    thisNote.data("state", "editable")
  }

  makeNoteReadOnly(thisNote) {
    // Once clicked turn into edit
    thisNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit')
    // Add read only attribute
    thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field")
    // Hide the update button
    thisNote.find(".update-note").removeClass("update-note--visible")
    // Add data state
    thisNote.data("state", "cancel")
  }

  updateNote(e) {
    // Grab the note based on what was clicked
    const thisNote = $(e.target).parents("li")

    // Create new post object
    const ourUpdatedPost = {
      title: thisNote.find(".note-title-field").val(),
      content: thisNote.find(".note-body-field").val()
    }

    // Send post request
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
      },
      url: universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.data("id"),
      type: "POST",
      data: ourUpdatedPost,
      success: response => {
        // With success response from server - switch to ready only mode
        this.makeNoteReadOnly(thisNote)
        console.log("Congrats!")
        console.log(response)
      },
      error: error => {
        console.log("sorry")
        console.log(error)
      }
    })
  }
}

export default MyNotes
