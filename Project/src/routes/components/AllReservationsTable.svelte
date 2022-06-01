<script>
    import { reservListTypes } from "../../js/app";
    import ChevronCircleUp from "svelte-icons/fa/FaChevronCircleUp.svelte";
    import ChevronCircleDown from "svelte-icons/fa/FaChevronCircleDown.svelte";
    import AllReservationsRow from "./AllReservationsRow.svelte";

    export let res;
    export let itemUp;
    export let indexUp;
    export let accepted;
    export let setSort;
    export let sortBy;
    export let sortDir;
    export let changeVal;
</script>

<div class="xl:w-11/12 w-full mx-auto overflow-auto my-5">
    <h1
        class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-100 text-center my-12"
    >
        {itemUp.toUpperCase()}
    </h1>
    <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
            <tr>
                <th
                    class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs md:text-sm xl:text-lg bg-gray-100 text-center rounded-tl"
                    >Lp</th
                >
                {#each ["USER", "CAR", "DATE"] as item}
                    <th
                        on:click={setSort(
                            indexUp,
                            itemUp,
                            reservListTypes[item]
                        )}
                        class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs md:text-sm xl:text-lg cursor-pointer bg-gray-100 text-center flex-row justify-center items-center"
                    >
                        <div class="flex flex-row items-center justify-center">
                            <div class="w-5" />
                            <p>
                                {item[0] + item.slice(1).toLowerCase()}
                                {item == "DATE" ? " Start" : ""}
                            </p>
                            <div class="icon w-4 h-4 ml-1 text-gray-900">
                                {#if sortBy[indexUp] == reservListTypes[item]}
                                    {#if sortDir[indexUp] == "UP"}
                                        <ChevronCircleUp />
                                    {:else}
                                        <ChevronCircleDown />
                                    {/if}
                                {/if}
                            </div>
                        </div>
                    </th>
                {/each}
                <th
                    class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs md:text-sm xl:text-lg bg-gray-100 text-center"
                    >Date End</th
                >
                {#if itemUp == "waiting"}
                    <th
                        class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs md:text-sm xl:text-lg bg-gray-100 text-center rounded-tr"
                        >Accept</th
                    >
                {:else if itemUp != "archival"}
                    {#if itemUp == "accepted"}
                        <th
                            class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs md:text-sm xl:text-lg bg-gray-100 text-center"
                            >UPDATE</th
                        >
                    {/if}
                    <th
                        class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs md:text-sm xl:text-lg bg-gray-100 text-center rounded-tr"
                        >Delete</th
                    >
                {/if}
            </tr>
        </thead>
        <tbody>
            {#each res[itemUp] as item, i}
                <AllReservationsRow
                    {i}
                    {accepted}
                    {item}
                    {itemUp}
                    {changeVal}
                />
            {/each}
        </tbody>
    </table>
</div>
