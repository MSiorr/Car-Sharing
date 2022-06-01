<script>
    export let item;
    export let carDetail;
</script>

<tr>
    <td
        class="border-t-2 border-b-2 border-gray-200 md:px-4 py-3 text-gray-100 text-center"
    >
        <img
            src={item.img}
            alt={item.brand}
            class="w-96 rounded shadow-white-lg m-auto mb-4 mt-4 min-w-100p"
        />
    </td>
    <td
        class="xl:text-xl border-t-2 border-b-2 border-gray-200 md:px-4 py-3 text-gray-100 text-center"
        >{item.model}</td
    >
    <td
        class="xl:text-xl border-t-2 border-b-2 border-gray-200 md:px-4 py-3 text-gray-100 text-center"
        >{item.brand}</td
    >
    <td
        class="xl:text-xl border-t-2 border-b-2 border-gray-200 md:px-4py-3 text-gray-100 text-center"
        >{item.year}</td
    >
    <td
        class="xl:text-2xl font-bold border-t-2 border-b-2 border-gray-200 md:px-4 py-3 text-yellow-400 text-center"
        >{item.price}$</td
    >
    <td
        class="xl:text-xl border-t-2 border-b-2 border-gray-200 md:px-4 py-3 text-gray-100 text-center"
    >
        <button
            on:click={() => {
                carDetail(item.offerID);
            }}
            class="shadow-white-lg p-2 rounded bg-yellow-500 border-none text-black cursor-pointer hover:bg-yellow-400"
            >DETAILS&nbsp;&gt;</button
        >
    </td>
</tr>
