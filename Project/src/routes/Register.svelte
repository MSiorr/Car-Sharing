<script>
    import * as APP from "../js/app.js";
    import Loader from "./components/Loader.svelte";
    let canRegister = false;
    let login, password, email;

    function onRegister(e) {
        e.preventDefault();
        if (login && password && email) {
            let form = new FormData();
            form.append("login", login);
            form.append("password", password);
            form.append("email", email);

            fetch("./backend/Register.php", {
                method: "POST",
                body: form,
                mode: "no-cors",
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.locReload) {
                        location.href = "./#";
                    }
                    APP.displayMessage(
                        !data.opperation,
                        data.info,
                        document.getElementById("header")
                    );
                    if (data.opperation == true) {
                        [login, password, email] = new Array(3).fill("");
                    }
                });
        } else {
            APP.displayMessage(
                true,
                "Wrong data",
                document.getElementById("header")
            );
        }
    }

    APP.checkStatus().then((status) => {
        if (status.logged == false) {
            canRegister = true;
        } else {
            location.href = "./#";
        }
    });
</script>

{#if canRegister}
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1
                    class="sm:text-5xl text-2xl font-medium title-font mb-4 text-gray-100"
                >
                    Register
                </h1>
                <p
                    class="lg:w-2/3  sm:text-2xl text-xl mx-auto leading-relaxed"
                >
                    Join the ExoticShare community
                </p>
            </div>
            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                <form
                    class="flex flex-wrap -m-2"
                    on:submit={onRegister.bind(this)}
                >
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label
                                for="login"
                                class="leading-7 text-sm text-gray-600"
                                >Login</label
                            >
                            <input
                                bind:value={login}
                                type="text"
                                id="login"
                                name="login"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-yellow-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            />
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label
                                for="pass"
                                class="leading-7 text-sm text-gray-600"
                                >Password</label
                            >
                            <input
                                bind:value={password}
                                type="password"
                                id="pass"
                                name="pass"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-yellow-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            />
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label
                                for="email"
                                class="leading-7 text-sm text-gray-600"
                                >Email</label
                            >
                            <input
                                bind:value={email}
                                type="email"
                                id="email"
                                name="email"
                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-yellow-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            />
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <input
                            type="submit"
                            class="flex mx-auto cursor-pointer text-black bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-400 rounded text-lg"
                            value="Register"
                        />
                    </div>
                </form>
            </div>
        </div>
    </section>
{:else}
    <Loader />
{/if}
