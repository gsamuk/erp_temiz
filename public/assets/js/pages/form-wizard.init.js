document.querySelector("#profile-img-file-input").addEventListener("change",(function(){var e=document.querySelector(".user-profile-image"),t=document.querySelector(".profile-img-file-input").files[0],o=new FileReader;o.addEventListener("load",(function(){e.src=o.result}),!1),t&&o.readAsDataURL(t)})),document.querySelectorAll(".form-steps").forEach((function(e){e.querySelectorAll(".nexttab").forEach((function(t){e.querySelectorAll('button[data-bs-toggle="pill"]').forEach((function(e){e.addEventListener("show.bs.tab",(function(e){e.target.classList.add("done")}))})),t.addEventListener("click",(function(){var e=t.getAttribute("data-nexttab");document.getElementById(e).click()}))})),e.querySelectorAll(".previestab").forEach((function(e){e.addEventListener("click",(function(){for(var t=e.getAttribute("data-previous"),o=e.closest("form").querySelectorAll(".custom-nav .done").length,r=o-1;r<o;r++)e.closest("form").querySelectorAll(".custom-nav .done")[r]&&e.closest("form").querySelectorAll(".custom-nav .done")[r].classList.remove("done");document.getElementById(t).click()}))}));var t=e.querySelectorAll('button[data-bs-toggle="pill"]');t.forEach((function(o,r){o.setAttribute("data-position",r),o.addEventListener("click",(function(){if(o.getAttribute("data-progressbar")){var n=document.getElementById("custom-progress-bar").querySelectorAll("li").length-1,l=r/n*100;document.getElementById("custom-progress-bar").querySelector(".progress-bar").style.width=l+"%"}e.querySelectorAll(".custom-nav .done").length>0&&e.querySelectorAll(".custom-nav .done").forEach((function(e){e.classList.remove("done")}));for(var c=0;c<=r;c++)t[c].classList.contains("active")?t[c].classList.remove("done"):t[c].classList.add("done")}))}))}));
