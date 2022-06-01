<script>
    import TachometerAlt from "svelte-icons/fa/FaTachometerAlt.svelte";
    import Cog from "svelte-icons/fa/FaCog.svelte";
    import UserAlt from "svelte-icons/fa/FaUserAlt.svelte";
    import UserClock from "svelte-icons/fa/FaUserClock.svelte";
    import Palette from "svelte-icons/fa/FaPalette.svelte";
    import DollarSign from "svelte-icons/fa/FaDollarSign.svelte";

    export let size;
    export let type;
    export let data;
    export let color;
</script>

<div class="flex mx-2 my-2 flex-row items-center">
    <div
        class="icon w-8 h-8 {color} {size == 'BIG'
            ? 'xl:w-12 xl:h-12'
            : 'xl:w-10 xl:h-10'}"
    >
        {#if type == "TachometerAlt"}
            <TachometerAlt />
        {:else if type == "Cog"}
            <Cog />
        {:else if type == "UserAlt"}
            <UserAlt />
        {:else if type == "UserClock"}
            <UserClock />
        {:else if type == "Palette"}
            <Palette />
        {:else if type == "DollarSign"}
            <DollarSign />
        {/if}
    </div>
    <p class="text-gray-500 ml-4 {color}">
        {data}
    </p>
</div>
