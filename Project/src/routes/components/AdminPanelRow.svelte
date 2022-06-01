<script>
    export let i;
    export let item;
    export let changeVal;
</script>

<tr>
    <td
        class="border-t-2 border-b-2 border-gray-200 lg:px-4 py-3 text-xs sm:text-sm lg:text-lg text-gray-100 text-center"
        >{i}</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 lg:px-4 py-3 text-xs sm:text-sm lg:text-lg text-gray-100 text-center"
        >{item.login}</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 lg:px-4 py-3 text-xs sm:text-sm lg:text-lg text-gray-100 text-center"
        >{item.email}</td
    >
    <td
        class="border-t-2 border-b-2 border-gray-200 lg:px-4 py-3 text-xs sm:text-sm lg:text-lg text-gray-100 text-center"
        >{item.createTime}</td
    >
    {#if item.permiss == "admin"}
        {#each [0, 0, 0] as item}
            <td
                class="border-t-2 border-b-2 border-gray-200 lg:px-4 py-3 text-xs sm:text-sm lg:text-lg text-gray-100 text-center"
            >
                <button
                    class="w-20 h-10 rounded bg-gray-500 cursor-not-allowed"
                    disabled
                >
                    Change
                </button>
            </td>
        {/each}
    {:else}
        <td
            class="border-t-2 border-b-2 border-gray-200 lg:px-4 py-3 text-xs sm:text-sm lg:text-lg text-gray-100 text-center"
        >
            <button
                on:click={changeVal(item.id, "modChange")}
                class="w-20 h-10 rounded cursor-pointer
            {item.permiss == 'client'
                    ? 'bg-red-600 hover:bg-red-500'
                    : 'bg-green-500 hover:bg-green-400'}"
            >
                Change</button
            >
        </td>
        <td
            class="border-t-2 border-b-2 border-gray-200 lg:px-4 py-3 text-xs sm:text-sm lg:text-lg text-gray-100 text-center"
        >
            <button
                on:click={changeVal(item.id, "activeChange")}
                class="w-20 h-10 rounded cursor-pointer
            {item.active == false
                    ? 'bg-red-600 hover:bg-red-500'
                    : 'bg-green-500 hover:bg-green-400'}"
            >
                Change</button
            >
        </td>
        <td
            class="border-t-2 border-b-2 border-gray-200 lg:px-4 py-3 text-xs sm:text-sm lg:text-lg text-gray-100 text-center"
        >
            <button
                on:click={changeVal(item.id, "banChange")}
                class="w-20 h-10 rounded cursor-pointer
        {item.banned == false
                    ? 'bg-red-600 hover:bg-red-500'
                    : 'bg-green-500 hover:bg-green-400'}"
            >
                Change</button
            >
        </td>
    {/if}
</tr>
