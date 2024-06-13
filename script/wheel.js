document.addEventListener("DOMContentLoaded",()=>{
    const go = document.querySelector(".go")
    const wheel = document.querySelector(".wheel")

    go.addEventListener("click", () => {
        /*
            0deg [360] = brochettes 
            60deg [360] = perdu
            120deg [360] = frites
            180deg [360] = canette
            240deg [360] = perdu
            300deg [360] = burger

            3 tours minimum = 3*360 = 1080deg min
        */

        // pourcentages de chance :

        let rand = Math.floor(Math.random() * 100 + 1)
        let rot = 1080

        if (rand<=18) { // brochettes 18%
            rot += 0
        }
        else if (rand<=38) { // perdu 20%
            rot += 60
        }
        else if (rand<=56) { // frites 18%
            rot += 120
        }
        else if (rand<=74) { // canette 18%
            rot += 180
        }
        else if (rand<=94) { // perdu 20%
            rot += 240
        }
        else if (rand<=100) { // burger 6%
            rot += 300
        }

        wheel.style.transform = "rotate("+rot+"deg)"
        go.disabled = true
        go.classList.add("disabled")
        go.innerHTML = "Ca tourne !"
    })
})