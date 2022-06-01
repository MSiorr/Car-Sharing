<script>
    export let params;
    import { displayMessage } from "../js/app";
    import Loader from "./components/Loader.svelte";
    import MyIcon from "./components/MyIcon.svelte";

    let today = new Date(Date.now());

    let startDate, endDate, logged;

    let resDays = 0;
    let pricePerDay = 0;

    let carInfo = getCarInfo(params.id);

    async function getCarInfo(id) {
        let form = new FormData();
        form.append("id", id);
        const URL = "./backend/CarInfo.php";
        let res = await fetch(URL, {
            method: "POST",
            body: form,
            mode: "no-cors",
        });
        res = await res.json();
        pricePerDay = parseInt(res.data.price);
        logged = res.logged;
        return res;
    }

    function setDate(type, input) {
        if (type == "start") {
            startDate = input.target.value;
        } else {
            endDate = input.target.value;
        }
        if (startDate && endDate) {
            let sTime = new Date(startDate).getTime();
            let eTime = new Date(endDate).getTime();
            let sub = eTime - sTime;
            resDays = Math.round(sub / 86400000);
        }
    }

    async function reservCar(queueStatus = false) {
        if (queueStatus) {
            location.href = "./#/myReservations";
        } else {
            if (resDays > 0 && logged == true) {
                let form = new FormData();
                form.append("offerID", params.id);
                form.append("endPrice", resDays * pricePerDay);
                form.append("resStart", startDate);
                form.append("resTime", resDays);
                const URL = "./backend/MakeReserv.php";
                let res = await fetch(URL, {
                    method: "POST",
                    body: form,
                    mode: "no-cors",
                });
                res = await res.json();
                if (res.status == true) {
                    carInfo = getCarInfo(params.id);
                }
                displayMessage(
                    !res.status,
                    res.info,
                    document.getElementById("header")
                );
            } else {
                displayMessage(
                    true,
                    logged == false
                        ? "You must be logged in"
                        : "Wrong reservation date",
                    document.getElementById("header")
                );
            }
        }
    }
</script>

{#await carInfo}
    <Loader />
{:then res}
    <section class="text-gray-600 body-font h-full">
        <div class="w-full mx-auto flex items-center justify-center flex-col">
            <img
                class="w-full mb-10 object-cover object-center rounded"
                alt="hero"
                src={res.data.img}
            />
            <div
                class="-mt-2 sm:-mt-14 md:-mt-20 h-14 w-full myBg shadow-myBg-top"
            />
            <div class="text-center md:w-10/12 w-full mb-10 px-4">
                <h1
                    class="title-font sm:text-7xl 2xl:text-8xl text-3xl mb-4 font-medium text-gray-100"
                >
                    {res.data.model}
                    {res.data.brand}
                </h1>
                <p class="mb-8 leading-relaxed sm:text-lg 2xl:text-2xl mt-10">
                    {res.data.description}
                </p>
                <div
                    class="flex items-center flex-row justify-evenly text-sm lg:text-2xl md:text-xl flex-wrap"
                >
                    <MyIcon
                        type={"TachometerAlt"}
                        data={`${res.data.acceleration}s (0 - 100 km/h)`}
                        size={"SMALL"}
                        color={"text-gray-600"}
                    />
                    <MyIcon
                        type={"Cog"}
                        data={res.data.gearbox}
                        size={"SMALL"}
                        color={"text-gray-600"}
                    />
                    <MyIcon
                        type={"UserAlt"}
                        data={res.data.places}
                        size={"SMALL"}
                        color={"text-gray-600"}
                    />
                    <MyIcon
                        type={"Palette"}
                        data={res.data.color}
                        size={"SMALL"}
                        color={"text-gray-600"}
                    />
                </div>
                <div
                    class="flex items-center flex-row justify-evenly mt-10 text-md lg:text-3xl md:text-2xl"
                >
                    <MyIcon
                        type={"UserClock"}
                        data={res.data.resNum}
                        size={"BIG"}
                        color={"text-gray-600"}
                    />
                    <MyIcon
                        type={"DollarSign"}
                        data={`${res.data.price}$ / day`}
                        size={"BIG"}
                        color={"text-yellow-500"}
                    />
                </div>
                <div class="mt-20 border-4 rounded-lg">
                    {#if res.available == true}
                        {#if res.inQueue == false || res.myStatus == "declined"}
                            <div
                                class="flex flex-row w-full justify-evenly mt-4 flex-wrap"
                            >
                                <div class="flex flex-col w-11/12 md:w-5/12">
                                    <p
                                        class="w-full pl-2 text-left text-gray-200 py-1"
                                    >
                                        Start
                                    </p>
                                    <input
                                        bind:value={startDate}
                                        on:change={(e) =>
                                            setDate.bind(this, "start")(e)}
                                        class="text-md lg:text-lg py-2 px-2 w-full rounded bg-gray-900 text-gray-300"
                                        type="date"
                                        min="{today.getFullYear()}-{today.getMonth() +
                                            1}-{today.getDate()}"
                                    />
                                </div>
                                <div class="flex flex-col w-11/12 md:w-5/12">
                                    <p
                                        class="w-full pl-2 text-left text-gray-200 py-1 mt-4 md:mt-0"
                                    >
                                        End
                                    </p>
                                    <input
                                        bind:value={endDate}
                                        on:change={(e) =>
                                            setDate.bind(this, "end")(e)}
                                        class="text-md lg:text-lg py-2 px-2 w-full rounded bg-gray-900 text-gray-300"
                                        type="date"
                                        min="{new Date(
                                            today.getTime() + 86400000
                                        ).getFullYear()}-{new Date(
                                            today.getTime() + 86400000
                                        ).getMonth() + 1}-{new Date(
                                            today.getTime() + 86400000
                                        ).getDate()}"
                                    />
                                </div>
                            </div>
                            <div
                                class="flex flex-row w-full justify-evenly mt-4 flex-wrap"
                            >
                                <p
                                    class="{resDays < 0
                                        ? 'text-red-500'
                                        : 'text-yellow-400'} py-4 text-2xl lg:text-3xl w-11/12 md:w-5/12"
                                >
                                    DAYS: {Math.max(0, resDays)}
                                </p>
                                <p
                                    class="{resDays < 0
                                        ? 'text-red-500'
                                        : 'text-yellow-400'} py-4 text-2xl lg:text-3xl w-11/12 md:w-5/12"
                                >
                                    END PRICE: {Math.max(
                                        0,
                                        resDays * res.data.price
                                    )} $
                                </p>
                            </div>
                            <button
                                on:click={reservCar.bind(
                                    this,
                                    res.myStatus == "declined"
                                        ? false
                                        : res.inQueue
                                )}
                                class="w-11/12 py-4 rounded text-3xl m-4 mt-2 {res
                                    .data.resNum == '0'
                                    ? 'bg-green-500 text-gray-100'
                                    : 'bg-yellow-400 text-gray-900'}"
                                >RESERV</button
                            >
                        {:else}
                            <button
                                on:click={reservCar.bind(this, res.inQueue)}
                                class="w-11/12 py-4 rounded text-3xl m-4 mt-4 {res.myStatus ==
                                'accepted'
                                    ? 'bg-green-500 text-gray-100'
                                    : 'bg-yellow-400 text-gray-900'}"
                                >{res.myStatus == "accepted"
                                    ? "This car is currently yours"
                                    : "You're already in queue"}</button
                            >
                        {/if}
                    {:else}
                        <button
                            on:click={() => {
                                displayMessage(
                                    true,
                                    "The car is unavailable",
                                    document.getElementById("header")
                                );
                            }}
                            class="w-11/12 py-4 rounded text-3xl m-4 mt-4 bg-red-600 text-gray-100"
                            >This car is unavailable</button
                        >
                    {/if}
                </div>
            </div>
        </div>
    </section>
{/await}
