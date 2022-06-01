<script>
    import { carListTypes, mySort } from "../js/app";
    import ChevronCircleUp from "svelte-icons/fa/FaChevronCircleUp.svelte";
    import ChevronCircleDown from "svelte-icons/fa/FaChevronCircleDown.svelte";
    import CarListRow from "./components/carListRow.svelte";
    import Loader from "./components/Loader.svelte";

    let canRender = false;

    let carList = getCars();
    let tempList = [];
    let archList = [];

    let sortedBy;
    let sortDirect = "UP";

    let models = [];
    let brands = [];
    let years = [];
    let prices = [];

    let filtrModel = "all";
    let filtrBrand = "all";
    let filtrYear = "all";
    let filtrPrice = "all";

    async function getCars() {
        const URL = "./backend/CarList.php";
        let res = await fetch(URL, { method: "GET" });
        res = await res.json();
        tempList = res.cars;
        archList = res.cars;
        models = res.cars
            .map((e) => e.model)
            .filter((e, i, a) => a.indexOf(e) == i);
        fixFilters(res.cars);
        canRender = true;
        return res;
    }

    function fixFilters(tab) {
        brands = tab.map((e) => e.brand).filter((e, i, a) => a.indexOf(e) == i);
        years = tab.map((e) => e.year).filter((e, i, a) => a.indexOf(e) == i);
        prices = tab.map((e) => e.price).filter((e, i, a) => a.indexOf(e) == i);

        if (filtrBrand != "all") {
            if (brands.indexOf(filtrBrand) == -1) {
                filtrBrand = "all";
            }
        }
        if (filtrYear != "all") {
            if (years.indexOf(filtrYear) == -1) {
                filtrYear = "all";
            }
        }
        if (filtrPrice != "all") {
            if (prices.indexOf(filtrPrice) == -1) {
                filtrPrice = "all";
            }
        }
    }

    function carDetail(id) {
        location.href = `./#/carInfo/${id}`;
    }

    function filtrCars(type, select) {
        sortedBy = undefined;
        sortDirect = "UP";
        if (type == "model") {
            filtrModel = select.value;
            filtrPrice = "all";
            filtrBrand = "all";
            filtrYear = "all";
        } else if (type == "brand") {
            filtrBrand = select.value;
        } else if (type == "year") {
            filtrYear = select.value;
        } else if (type == "price") {
            filtrPrice = select.value;
        }

        if (carList) {
            if (filtrModel == "all") {
                tempList = Array.from(archList);
            } else {
                tempList = archList.filter((e) => e.model == filtrModel);
                fixFilters(tempList);
            }
            if (filtrBrand != "all") {
                tempList = tempList.filter((e) => e.brand == filtrBrand);
                fixFilters(tempList);
            }
            if (filtrYear != "all") {
                tempList = tempList.filter((e) => e.year == filtrYear);
                fixFilters(tempList);
            }
            if (filtrPrice != "all") {
                tempList = tempList.filter((e) => e.price == filtrPrice);
                fixFilters(tempList);
            }

            carList = Promise.resolve({
                cars: tempList,
            });
        }
    }

    function setSort(type) {
        if (sortedBy != type) {
            sortedBy = type;
            sortDirect = "UP";
        } else {
            sortDirect = sortDirect == "UP" ? "DOWN" : "UP";
        }
        if (carList) {
            carList = Promise.resolve({
                cars: mySort(tempList, sortDirect, sortedBy),
            });
        }
    }
</script>

{#if canRender == true}
    <section id="carSection" class="text-gray-600 body-font myBg">
        <div class="px-0 md:px-2 py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1
                    class="sm:text-6xl text-3xl font-medium title-font mb-2 text-gray-100"
                >
                    Our Cars
                </h1>
                <p
                    class="lg:w-11/12 md:text-2xl mx-auto leading-relaxed text-base"
                >
                    Every car has a soul, you just have to listen
                </p>
                <div
                    class="flex flex-row w-full md:w-11/12 justify-evenly mt-10 flex-wrap mx-auto"
                >
                    {#each [{ v: filtrModel, tab: models }, { v: filtrBrand, tab: brands }, { v: filtrYear, tab: years }, { v: filtrPrice, tab: prices }] as item, i}
                        <div class="relative w-11/12 md:w-5/12 py-2">
                            <p class="text-left pl-1 text-gray-400">
                                {i == 0
                                    ? carListTypes.MODEL
                                    : i == 1
                                    ? carListTypes.BRAND
                                    : i == 2
                                    ? carListTypes.YEAR
                                    : carListTypes.PRICE}
                            </p>
                            <select
                                bind:value={item.v}
                                on:input={(e) =>
                                    filtrCars.bind(
                                        this,
                                        i == 0
                                            ? carListTypes.MODEL
                                            : i == 1
                                            ? carListTypes.BRAND
                                            : i == 2
                                            ? carListTypes.YEAR
                                            : carListTypes.PRICE
                                    )(e.target)}
                                class="w-full rounded border text-gray-100 appearance-none bg-gray-900 border-gray-100 py-2 focus:outline-none focus:ring-2 focus:ring-gray-100 focus:border-gray-100 text-base pl-3 pr-10"
                            >
                                <option value="all">All</option>
                                {#each item.tab as sItem}
                                    <option value={sItem}>{sItem}</option>
                                {/each}
                            </select>
                            <span
                                class="absolute right-0 top-3 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center"
                            >
                                <svg
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    class="w-4 h-4"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </span>
                        </div>
                    {/each}
                </div>
            </div>
            <div class="lg:w-11/12 w-full mx-auto overflow-auto">
                {#await carList}
                    &nbsp;
                {:then res}
                    <table
                        class="table-auto w-full text-left whitespace-no-wrap"
                    >
                        <thead>
                            <tr>
                                <th
                                    class="xl:text-xl px-4 py-3 title-font tracking-wider font-medium text-center text-gray-900 text-sm bg-gray-100 rounded-tl "
                                    >Car</th
                                >
                                {#each ["MODEL", "BRAND", "YEAR", "PRICE"] as item}
                                    <th
                                        on:click={setSort.bind(
                                            this,
                                            carListTypes[item]
                                        )}
                                        class="xl:text-xl px-4 py-3 title-font tracking-wider font-medium text-center text-gray-900 text-sm bg-gray-100 cursor-pointer flex-row justify-center items-center"
                                    >
                                        <div
                                            class="flex flex-row items-center justify-center"
                                        >
                                            <div class="w-5" />
                                            <p>
                                                {item[0] +
                                                    item.slice(1).toLowerCase()}
                                                {item == "PRICE"
                                                    ? "($/day)"
                                                    : ""}
                                            </p>
                                            <div
                                                class="icon w-4 h-4 ml-1 text-gray-900"
                                            >
                                                {#if sortedBy == carListTypes[item]}
                                                    {#if sortDirect == "UP"}
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
                                    class="xl:text-xl px-4 py-3 title-font tracking-wider font-medium text-center text-gray-900 text-sm bg-gray-100 rounded-tr"
                                    >Go</th
                                >
                            </tr>
                        </thead>
                        <tbody>
                            {#each res.cars as item}
                                <CarListRow
                                    {item}
                                    carDetail={carDetail.bind(this)}
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
