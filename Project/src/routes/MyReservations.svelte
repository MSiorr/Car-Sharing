<script>
    import { checkStatus, displayMessage } from "../js/app";
    import Loader from "./components/Loader.svelte";
    import MyReservationsTable from "./components/MyReservationsTable.svelte";

    let canRender = false;
    let reservations;

    async function getMyReservations() {
        const URL = "./backend/MyReservations.php";
        let res = await fetch(URL, { method: "GET" });
        res = await res.json();
        return res;
    }

    async function changeVal(action, id, rentID = false) {
        let form = new FormData();
        form.append("action", action);
        form.append("id", id);
        if (action == "returnCar") {
            form.append("rentID", rentID);
        }

        fetch("./backend/MyReservations.php", {
            method: "POST",
            body: form,
            mode: "no-cors",
        })
            .then((res) => res.json())
            .then((data) => {
                reservations = getMyReservations();
                displayMessage(
                    !data.action,
                    data.info,
                    document.getElementById("header")
                );
            });
    }

    checkStatus().then((status) => {
        if (status.logged == true) {
            canRender = true;
            reservations = getMyReservations();
        } else {
            location.href = "./#";
        }
    });
</script>

{#if canRender}
    <section class="text-gray-600 body-font">
        <div class="px-0 lg:px-5 pb-24 pt-4 mx-auto">
            {#await reservations}
                loading data...
            {:then res}
                {#each ["waiting", "accepted", "declined"] as itemUp}
                    <MyReservationsTable
                        {itemUp}
                        {res}
                        changeVal={changeVal.bind(this)}
                    />
                {/each}
            {/await}
        </div>
    </section>
{:else}
    <Loader />
{/if}
