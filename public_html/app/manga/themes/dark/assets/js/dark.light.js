    const toggleSwitch = document.querySelector('#theme-toggle input[type="checkbox"]');
    toggleSwitch.addEventListener('change', switchTheme, false);
  
    if(localStorage.getItem('theme') == "colorscheme-dark") {
      toggleSwitch.checked = false;
      switchTheme()
    }
  
    function switchTheme() {
      let section = document.getElementsByTagName("section")[0];
      let theme = section.className == "colorscheme-dark" ? "colorscheme-light" : "colorscheme-dark";
      section.className = ''
      section.classList.add(theme)
      localStorage.setItem('theme', theme);
    }