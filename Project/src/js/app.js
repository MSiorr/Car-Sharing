export let carListTypes = {
    MODEL: 'model',
    BRAND: 'brand',
    YEAR: 'year',
    PRICE: 'price'
}
export let reservListTypes = {
    USER: 'login',
    CAR: 'carName',
    DATE: 'resStart'
}

export function displayMessage(err, data, root) {
    let messageDiv = document.createElement('div');
    messageDiv.className = "absolute m-auto w-full rounded mt-2 transition-opacity duration-500 opacity-0 top-0 z-10";
    let msg = document.createElement('p')
    msg.className = "text-white block pt-2 pb-2 text-center text-1xl font-bold w-96 rounded m-auto"
    msg.classList.add(err ? "bg-red-600" : "bg-green-500")
    msg.innerText = data;
    messageDiv.appendChild(msg);

    root.append(messageDiv);

    setTimeout(() => {
        messageDiv.classList.add("opacity-100");
        messageDiv.classList.remove("opacity-0");

        setTimeout(() => {
            messageDiv.classList.remove("opacity-100");
            messageDiv.classList.add("opacity-0");
            setTimeout(() => {
                root.removeChild(messageDiv);
            }, 500)
        }, 1000);
    }, 10)
}

export async function checkStatus() {
    const URL = "./backend/Status.php";
    let res = await fetch(URL, { method: "GET" });
    res = await res.json();
    return res;
}

export function mySort(tab, direct, sortedBy) {
    let sortedTab = tab.sort((a, b) => {
        if (isNaN(a[sortedBy]) == true) {
            if (direct == "UP") {
                if (a[sortedBy] < b[sortedBy]) {
                    return -1;
                }
                if (a[sortedBy] > b[sortedBy]) {
                    return 1;
                }
                return 0;
            } else {
                if (a[sortedBy] > b[sortedBy]) {
                    return -1;
                }
                if (a[sortedBy] < b[sortedBy]) {
                    return 1;
                }
                return 0;
            }
        } else {
            return direct == "UP"
                ? a[sortedBy] - b[sortedBy]
                : b[sortedBy] - a[sortedBy];
        }
    });
    return sortedTab;
}

export function firstLetterBig(text) {
    return text[0].toUpperCase() + text.slice(1).toLowerCase()
}

export function calculateDate(startDate, time) {
    let date = new Date(startDate).getTime();
    let newDate = new Date(date + time * 86400000);
    return `${newDate.getFullYear().toString().padStart(2, "0")}-${(
        newDate.getMonth() + 1
    )
        .toString()
        .padStart(2, "0")}-${newDate
            .getDate()
            .toString()
            .padStart(2, "0")}`;
}

export function today() {
    let date = new Date(Date.now());
    return new Date(`${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`).getTime();
}

export function calculateDays(startDate, endDate) {
    let time = new Date(endDate).getTime() - new Date(startDate).getTime();
    return (time - (time % 86400000)) / 86400000;
}
