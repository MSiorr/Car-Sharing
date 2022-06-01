<script>
    import * as APP from "../../js/app";
    import ChevronCircleUp from "svelte-icons/fa/FaChevronCircleUp.svelte";
    import ChevronCircleDown from "svelte-icons/fa/FaChevronCircleDown.svelte";
    import Loader from "../components/Loader.svelte";
    import AllReservationsTable from "../components/AllReservationsTable.svelte";

    let canRender = false;
    let accepted = [];
    let reservations;
    let tempOb = null;
    let archOb = null;

    let sortBy = [undefined, undefined, undefined, undefined];
    let sortDir = ["UP", "UP", "UP", "UP"];

    async function getAllReservations() {
        const URL = "./backend/AllReservations.php";
        let res = await fetch(URL, { method: "GET" });
        res = await res.json();
        accepted = res.accepted;
        accepted.map(
            (e) => (e.resTime = APP.calculateDate(e.resStart, e.resTime))
        );
        tempOb = archOb = res;
        sortBy.forEach((e, i) => {
            if (e != undefined) {
                let where =
                    i == 0
                        ? "waiting"
                        : i == 1
                        ? "accepted"
                        : i == 2
                        ? "declined"
                        : "archival";
                sortDir[i] = sortDir[i] == "UP" ? "DOWN" : "UP";
                setSort(i, where, e);
            }
        });
        return res;
    }

    async function changeVal(action, id, type = null, array = null) {
        let form = new FormData();
        form.append("action", action);
        form.append("id", id);
        if (action == "changeStatus") {
            form.append("status", type);
        } else if (action == "deleteReserv") {
            form.append("rentID", type);
        } else if (action == "updateReserv") {
            for (let i = 0; i < array.length; i++) {
                if (array[i].id == id) {
                    form.append("resStart", array[i].resStart);
                    form.append(
                        "resTime",
                        APP.calculateDays(array[i].resStart, array[i].resTime)
                    );
                    break;
                }
            }
        }

        fetch("./backend/AllReservations.php", {
            method: "POST",
            body: form,
            mode: "no-cors",
        })
            .then((res) => res.json())
            .then((data) => {
                reservations = getAllReservations();
                APP.displayMessage(
                    !data.action,
                    data.info,
                    document.getElementById("header")
                );
            });
    }

    async function setSort(index, where, type) {
        if (sortBy[index] != type) {
            sortBy[index] = type;
            sortDir[index] = "UP";
        } else {
            sortDir[index] = sortDir[index] == "UP" ? "DOWN" : "UP";
        }

        if (reservations) {
            reservations[where] = Promise.resolve(
                APP.mySort(tempOb[where], sortDir[index], sortBy[index])
            );
            if (where == "accepted") {
                accepted = APP.mySort(accepted, sortDir[index], sortBy[index]);
            }
        }
    }

    APP.checkStatus().then((status) => {
        if (
            status.logged == true &&
            (status.permiss == "admin" || status.permiss == "mod")
        ) {
            canRender = true;
            reservations = getAllReservations();
        } else {
            location.href = "./#/notFound";
        }
    });
</script>

{#if canRender}
    <section class="text-gray-600 body-font">
        <div class="px-0 xl:px-5 pb-24 pt-4 mx-auto">
            {#await reservations}
                loading data...
            {:then res}
                {#each ["waiting", "accepted", "declined", "archival"] as itemUp, indexUp}
                    <AllReservationsTable
                        {res}
                        {itemUp}
                        {indexUp}
                        {accepted}
                        setSort={setSort.bind(this)}
                        {sortBy}
                        {sortDir}
                        changeVal={changeVal.bind(this)}
                    />
                {/each}
            {/await}
        </div>
    </section>
{:else}
    <Loader />
{/if}
