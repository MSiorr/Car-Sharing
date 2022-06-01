<script>
    import { calculateDate } from "../../js/app";

    export let item;
    export let i;
    export let itemUp;
    export let changeVal;
</script>

<tr>
    <td
        class="border-t-2 border-b-2 border-gray-200 sm:px-4 py-3 text-xs sm:text-sm md:text-lg text-gray-100 text-center"
        >{i}</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 sm:px-4 py-3 text-xs sm:text-sm md:text-lg text-gray-100 text-center"
        >{item.resStart}</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 sm:px-4 py-3 text-xs sm:text-sm md:text-lg text-gray-100 text-center"
        >{calculateDate(item.resStart, item.resTime)}</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 sm:px-4 py-3 text-xs sm:text-sm md:text-lg text-yellow-400 text-center"
        >{item.endPrice}$</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 sm:px-4 py-3 text-xs sm:text-sm md:text-lg text-gray-100 text-center"
        ><button
            on:click={() => {
                location.href = `./#/carInfo/${item.offerID}`;
            }}
            class="px-2 min-h-8 md:min-h-10 m-1 rounded cursor-pointer bg-yellow-500 hover:bg-yellow-400 text-black border-gray-900"
            >{item.model}&nbsp;{item.brand}&nbsp;&gt;</button
        ></td
    >
    {#if itemUp == "waiting"}
        <td
            class="border-t-2 border-b-2 border-gray-200 sm:px-4 py-3 text-xs sm:text-sm md:text-lg text-gray-100 text-center flex-row "
        >
            <button
                on:click={changeVal("cancelReserv", item.id)}
                class="w-16 h-8 md:w-20 md:h-10 m-1 rounded cursor-pointer
                bg-red-600 hover:bg-red-500"
            >
                CANCEL</button
            >
        </td>
    {:else if itemUp == "accepted"}
        <td
            class="border-t-2 border-b-2 border-gray-200 sm:px-4 py-3 text-xs sm:text-sm md:text-lg text-gray-100 text-center"
        >
            <button
                on:click={() => {
                    location.href = `./#/reservInfo/${item.rentID}`;
                }}
                class="px-2 h-8 md:h-10 m-1 rounded cursor-pointer bg-green-500 hover:bg-green-400'"
                >DRIVE&nbsp;&gt;</button
            >
        </td>
        <td
            class="border-t-2 border-b-2 border-gray-200 sm:px-4 py-3 text-xs sm:text-sm md:text-lg text-gray-100 text-center"
        >
            <button
                on:click={changeVal("returnCar", item.id, item.rentID)}
                class="w-16 h-8 md:w-20 md:h-10 m-1 rounded cursor-pointer
                bg-red-600 hover:bg-red-500"
            >
                RETURN</button
            >
        </td>
    {/if}
</tr>
