<script>
    import { calculateDate } from "../../js/app";

    export let i;
    export let accepted;
    export let item;
    export let itemUp;
    export let changeVal;
</script>

<tr>
    <td
        class="border-t-2 border-b-2 border-gray-200 xl:px-4 py-3 text-xs md:text-sm xl:text-lg text-gray-100 text-center"
        >{i}</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 xl:px-4 py-3 text-xs md:text-sm xl:text-lg text-gray-100 text-center"
        >{item.login}</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 xl:px-4 py-3 text-xs md:text-sm xl:text-lg text-gray-100 text-center"
    >
        {#if itemUp != "archival"}
            <button
                on:click={() => {
                    location.href = `./#/carInfo/${item.offerID}`;
                }}
                class="px-2 min-h-8 md:min-h-10 m-1 rounded cursor-pointer bg-yellow-500 hover:bg-yellow-400 text-black border-gray-900"
                >{item.carName}&nbsp;&gt;</button
            >
        {:else}
            {item.carName}
        {/if}
    </td>
    <td
        class="border-t-2 border-b-2 border-gray-200 xl:px-4 py-3 text-xs md:text-sm xl:text-lg text-gray-100 text-center"
    >
        {#if itemUp == "accepted"}
            <input
                class="text-md xl:text-lg py-2 px-1 rounded w-10/12 bg-gray-900 text-gray-300"
                type="date"
                bind:value={accepted[i].resStart}
            />
        {:else}
            {item.resStart}
        {/if}
    </td>
    <td
        class="border-t-2 border-b-2 border-gray-200 xl:px-4 py-3 text-xs md:text-sm xl:text-lg text-gray-100 text-center"
    >
        {#if itemUp == "accepted"}
            <input
                class="text-md xl:text-lg py-2 px-1 rounded w-10/12 bg-gray-900 text-gray-300"
                type="date"
                bind:value={accepted[i].resTime}
            />
        {:else}
            {calculateDate(item.resStart, item.resTime)}
        {/if}
    </td>
    {#if itemUp == "waiting"}
        <td
            class="border-t-2 border-b-2 border-gray-200 xl:px-4 py-3 text-xs md:text-sm xl:text-lg text-gray-100 text-center flex-row "
        >
            <button
                on:click={changeVal("changeStatus", item.id, "yes")}
                class="w-16 h-8 md:w-20 md:h-10 m-1 rounded cursor-pointer
                bg-green-500 hover:bg-green-400"
            >
                YES</button
            >
            <button
                on:click={changeVal("changeStatus", item.id, "no")}
                class="w-16 h-8 md:w-20 md:h-10 m-1 rounded cursor-pointer
                bg-red-600 hover:bg-red-500"
            >
                NO</button
            >
        </td>
    {:else}
        {#if itemUp == "accepted"}
            <td
                class="border-t-2 border-b-2 border-gray-200 xl:px-4 py-3 text-xs md:text-sm xl:text-lg text-gray-100 text-center"
            >
                <button
                    on:click={changeVal(
                        "updateReserv",
                        item.id,
                        null,
                        accepted
                    )}
                    class="w-16 h-8 md:w-20 md:h-10 m-1 rounded cursor-pointer
                    bg-green-500 hover:bg-green-400"
                >
                    UPDATE</button
                >
            </td>
        {/if}
        {#if itemUp != "archival"}
            <td
                class="border-t-2 border-b-2 border-gray-200 xl:px-4 py-3 text-xs md:text-sm xl:text-lg text-gray-100 text-center"
            >
                <button
                    on:click={changeVal("deleteReserv", item.id, item.rentID)}
                    class="w-16 h-8 md:w-20 md:h-10 m-1 rounded cursor-pointer
                    bg-red-600 hover:bg-red-500"
                >
                    DELETE</button
                >
            </td>
        {/if}
    {/if}
</tr>
