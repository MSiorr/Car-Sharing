<script>
    import { checkStatus } from "../../js/app";
    import AdminPanelRow from "../components/AdminPanelRow.svelte";
    import Loader from "../components/Loader.svelte";

    let canAdmin = false;
    let users;

    async function getAllUsers() {
        const URL = "./backend/AdminPanel.php";
        let res = await fetch(URL, { method: "GET" });
        res = await res.json();
        return res;
    }

    async function changeVal(id, type) {
        let form = new FormData();
        form.append("action", type);
        form.append("id", id);

        fetch("./backend/AdminPanel.php", {
            method: "POST",
            body: form,
            mode: "no-cors",
        })
            .then((res) => res.json())
            .then((data) => {
                users = getAllUsers();
            });
    }

    checkStatus().then((status) => {
        if (status.logged == true && status.permiss == "admin") {
            canAdmin = true;
            users = getAllUsers();
        } else {
            location.href = "./#/notFound";
        }
    });
</script>

{#if canAdmin}
    <section class="text-gray-600 body-font">
        <div class="lg:px-5 py-24 mx-auto">
            <div class="xl:w-11/12 w-full mx-auto overflow-auto">
                {#await users}
                    loading data...
                {:then res}
                    <table
                        class="table-auto w-full text-left whitespace-no-wrap"
                    >
                        <thead>
                            <tr>
                                <th
                                    class="lg:px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm lg:text-lg bg-gray-100 text-center rounded-tl"
                                    >Lp</th
                                >
                                <th
                                    class="lg:px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm lg:text-lg bg-gray-100 text-center"
                                    >Login</th
                                >
                                <th
                                    class="lg:px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm lg:text-lg bg-gray-100 text-center"
                                    >Email</th
                                >
                                <th
                                    class="lg:px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm lg:text-lg bg-gray-100 text-center"
                                    >Created</th
                                >
                                <th
                                    class="lg:px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm lg:text-lg bg-gray-100 text-center"
                                    >Mod</th
                                >
                                <th
                                    class="lg:px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm lg:text-lg bg-gray-100 text-center"
                                    >Active</th
                                >
                                <th
                                    class="lg:px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm lg:text-lg bg-gray-100 text-center rounded-tr"
                                    >Banned</th
                                >
                            </tr>
                        </thead>
                        <tbody>
                            {#each res.users as item, i}
                                <AdminPanelRow
                                    {item}
                                    {i}
                                    changeVal={changeVal.bind(this)}
                                />
                            {/each}
                        </tbody>
                    </table>
                {/await}
            </div>
        </div>
    </section>
{:else}
    <Loader />
{/if}
