import $ from "jquery"

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML()
    this.resultsDiv = $("#search-overlay__results")
    this.openButton = $(".js-search-trigger")
    this.closeButton = $(".search-overlay__close")
    this.searchOverlay = $(".search-overlay")
    this.searchField = $("#search-term")
    this.events()
    this.isOverlayOpen = false
    this.isSpinnerVisible = false
    this.previousValue
    this.typingTimer
  }

  // 2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this))
    this.closeButton.on("click", this.closeOverlay.bind(this))
    $(document).on("keydown", this.keyPressDispatcher.bind(this))
    this.searchField.on("keyup", this.typingLogic.bind(this))
  }

  // 3. methods (function, action...)
  typingLogic() {
    // Check if the value actually changes (avoid the arrow keys etc)
    if (this.searchField.val() != this.previousValue) {
      // clear previous timers
      clearTimeout(this.typingTimer)

      // Check for empty
      if (this.searchField.val()) {
        // Only if search field is not empty run this
        // Only add spinner code if not already there
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>')
          // Manage state for spinner
          this.isSpinnerVisible = true
        }
        // After some time call getResults()
        this.typingTimer = setTimeout(this.getResults.bind(this), 750)
      } else {
        // if field blank
        // empty out results div
        this.resultsDiv.html("")
        this.isSpinnerVisible = false
      }
    }

    // Set the value of the search field in the state previous value
    this.previousValue = this.searchField.val()
  }

  getResults() {
    $.getJSON(universityData.root_url + "/wp-json/university/v1/search?term=" + this.searchField.val(), results => {
      this.resultsDiv.html(`
      <div class="row">
        <div class="one-third">
          <h2 class="search-overlay__section-title" >General Information</h2>
          ${
            results.generalInfo.length
              ? '<ul class="link-list min-list" >'
              : `<p>No general information matches that search.</p><p><a href=${universityData.root_url}/posts>View all posts.</a></p></p>`
          }
          ${results.generalInfo
            .map(item => `<li><a href="${item.permalink}" >${item.title}</a> ${item.postType == "post" ? `by ${item.authorName}` : ""} </li>`)
            .join("")}
          ${results.generalInfo.length ? "</ul>" : ""}
        </div>
        <div class="one-third">
          <h2 class="search-overlay__section-title" >Projects</h2>
          ${results.projects.length ? "" : `<p>No projects match that search. <a href=${universityData.root_url}/projects>View all projects.</a></p>`}
          ${results.projects
            .map(
              item => `
            <div class="event-summary">
              <a class="event-summary__date t-center" href="${item.permalink}">
                <span class="event-summary__month">${item.month}</span>
                <span class="event-summary__day">${item.day}</span>  
                <span class="event-summary__year">${item.year}</span>  
              </a>
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                <p>${item.description}<a href="${item.permalink}" class="nu gray">Learn more</a></p>
            </div>
          </div>
          `
            )
            .join("")}


          <h2 class="search-overlay__section-title" >Skills</h2>
          ${
            results.skills.length
              ? '<ul class="link-list min-list" >'
              : `<p>No skills match that search. <a href=${universityData.root_url}/skills>View all skills.</a></p>`
          }
          ${results.skills.map(item => `<li><a href="${item.permalink}" >${item.title}</a></li>`).join("")}
          ${results.skills.length ? "</ul>" : ""}
        </div>
        <div class="one-third">
          <h2 class="search-overlay__section-title" >Clients</h2>
          ${
            results.clients.length
              ? '<ul class="professor-cards" >'
              : `<p>No clients match that search. <a href=${universityData.root_url}/clients>View all clients.</a></p>`
          }
          ${results.clients
            .map(
              item => `
          <li class="professor-card__list-item">
            <a class="professor-card" href="${item.permalink}">
              <img class="professor-card__image" src="${item.image}">
              <span class="professor-card__name">${item.title}</span>
            </a>
          </li>
          `
            )
            .join("")}
          ${results.clients.length ? "</ul>" : ""}
        </div>
      </div>
      `)
      this.isSpinnerVisible = false
    })
  }

  keyPressDispatcher(e) {
    if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(":focus")) {
      this.openOverlay()
    }

    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay()
    }
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active")
    $("body").addClass("body-no-scroll")

    // Reset search field when the overlay is opened again
    this.searchField.val("")

    // Wait for element to load properly
    setTimeout(() => this.searchField.focus(), 301)
    this.isOverlayOpen = true
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active")
    $("body").removeClass("body-no-scroll")
    console.log("our close method just ran!")
    this.isOverlayOpen = false
  }

  // Add search html
  addSearchHTML() {
    $("body").append(`
    <div class="search-overlay">
      <div class="search-overlay__top">
        <div class="container">
          <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
          <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term"
            autocomplete="off">
          <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
      </div>

      <div class="container">
        <div id="search-overlay__results"></div>
      </div>
    </div>
    `)
  }
}

// Class end

export default Search
