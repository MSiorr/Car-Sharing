<script>
    import { displayMessage, checkStatus } from "../js/app.js";
    import { store_STATUS } from "../stores/storeone";
    import Loader from "./components/Loader.svelte";

    let login, password;
    let canLogin = false;

    function onLogin(e) {
        e.preventDefault();
        if (login && password) {
            let form = new FormData();
            form.append("login", login);
            form.append("password", password);

            fetch("./backend/Login.php", {
                method: "POST",
                body: form,
                mode: "no-cors",
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.locReload || data.opperation) {
                        location.href = "./#";
                        let stat = checkStatus();
                        store_STATUS.update((v) => stat);
                    } else {
                        displayMessage(
                            !data.opperation,
                            data.info,
                            document.getElementById("header")
                        );
                    }
                });
        } else {
            displayMessage(
                true,
                "Wrong data",
                document.getElementById("header")
            );
        }
    }

    checkStatus().then((status) => {
        if (status.logged == false) {
            canLogin = true;
        } else {
            location.href = "./#";
        }
    });
</script>

{#if canLogin}
    <section id="loginSection" class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1
                    class="sm:text-5xl text-2xl font-medium title-font mb-4 text-gray-100"
                >
                    Login
                </h1>
            </div>
            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                <form
                    class="flex flex-wrap -m-2"
                    on:submit={onLogin.bind(this)}
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
                        <input
                            type="submit"
                            class="flex mx-auto text-black cursor-pointer bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-400 rounded text-lg"
                            value="Login"
                        />
                    </div>
                </form>
            </div>
        </div>
    </section>
{:else}
    <Loader />
{/if}
