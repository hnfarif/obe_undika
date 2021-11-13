/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

const chk = document.getElementById('chk');
var chkDark = localStorage.getItem("darkMode");

const enableDarkMode = () => {
  document.documentElement.classList.add('dark-theme');
  chk.setAttribute("checked", "checked")
  localStorage.setItem("darkMode", "enabled");
}

const disbaleDarkMode = () => {
  document.documentElement.classList.remove('dark-theme');
  chk.removeAttribute("checked", "checked")
  localStorage.setItem("darkMode", null);
}

if (chkDark === "enabled") {
  enableDarkMode();
}
chk.addEventListener('change', () => {

  chkDark = localStorage.getItem("darkMode");

  if (chkDark !== "enabled") {
    enableDarkMode();
    console.log(chkDark);
  } else {
    disbaleDarkMode();
    console.log(chkDark);
  }


});
