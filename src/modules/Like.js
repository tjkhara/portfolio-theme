import $ from "jquery"

class Like {
  // constructor
  constructor() {
    this.events()
  }

  // events
  events() {
    $(".like-box").on("click", this.ourClickDispatcher.bind(this))
  }

  // methods
  ourClickDispatcher(e) {
    var currentLikeBox = $(e.target).closest(".like-box")

    if (currentLikeBox.attr("data-exists") == "yes") {
      this.deleteLike(currentLikeBox)
    } else {
      this.createLike(currentLikeBox)
    }
  }

  createLike(currentLikeBox) {
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
      },
      url: universityData.root_url + "/wp-json/university/v1/manageLike",
      type: "POST",
      data: {
        postId: currentLikeBox.data("post")
      },
      success: response => {
        // Update heart to solid
        // To update with use attr
        currentLikeBox.attr("data-exists", "yes")

        // Increment count
        let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10)
        likeCount++

        // Output new number in html
        currentLikeBox.find(".like-count").html(likeCount)

        // Update the data-like
        // We get the id of the like post in the response
        currentLikeBox.attr("data-like", response)

        console.log(response)
      },
      error: response => {
        console.log(response)
      }
    })
  }

  deleteLike(currentLikeBox) {
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
      },
      url: universityData.root_url + "/wp-json/university/v1/manageLike",
      type: "DELETE",
      data: {
        // Can use attr to get value also
        like: currentLikeBox.attr("data-like")
      },
      success: response => {
        // Change heart to hollow
        currentLikeBox.attr("data-exists", "no")

        // Decrease number
        let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10)
        likeCount--

        // Output new number in html
        currentLikeBox.find(".like-count").html(likeCount)

        // Update the data-like
        // We get the id of the like post in the response
        currentLikeBox.attr("data-like", "")

        console.log(response)
      },
      error: response => {
        console.log(response)
      }
    })
  }
}

export default Like
