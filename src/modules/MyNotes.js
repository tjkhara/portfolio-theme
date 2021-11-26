import $ from "jquery"

class MyNotes {
  // constructor
  constructor() {
    this.events()
  }

  // events
  events() {
    $("#my-notes").on("click", ".delete-note", this.deleteNote.bind(this))
    $("#my-notes").on("click", ".edit-note", this.editNote.bind(this))
    $("#my-notes").on("click", ".update-note", this.updateNote.bind(this))
    $(".submit-note").on("click", this.createNote.bind(this))
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
        if (response.userNoteCount < 21) {
          $(".note-limit-message").removeClass("active")
        }
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

  // Create note
  createNote(e) {
    // Create new post object
    const ourNewPost = {
      title: $(".new-note-title").val(),
      content: $(".new-note-body").val(),
      status: "publish"
    }

    // Send post request
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
      },
      url: universityData.root_url + "/wp-json/wp/v2/note/",
      type: "POST",
      data: ourNewPost,
      success: response => {
        // Dynamically add to the page
        // Clear fields
        $(".new-note-title, .new-note-body").val("")
        // Slide down new post
        // Prepend to parent ul
        $(`
        <li data-id="${response.id}">
        <input readonly class="note-title-field" value="${response.title.raw}">
        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
        <textarea readonly
          class="note-body-field">${response.content.raw}</textarea>
        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>
          Save</span>
      </li>
        `)
          .prependTo("#my-notes")
          .hide()
          .slideDown()

        console.log("Congrats!")
        console.log(response)
      },
      error: response => {
        if (response.responseText == "You have reached your note limit.") {
          $(".note-limit-message").addClass("active")
        }
        console.log("sorry")
        console.log(response)
      }
    })
  }
}

export default MyNotes
