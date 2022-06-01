<script>
	import Router from "svelte-spa-router";
	import Tailwindcss from "./Tailwindcss.svelte";
	import Footer from "./components/Footer.svelte";
	import Header from "./components/Header.svelte";

	import Home from "./routes/Home.svelte";
	import Login from "./routes/Login.svelte";
	import Register from "./routes/Register.svelte";
	import AdminPanel from "./routes/mod&Admin/AdminPanel.svelte";
	import CarList from "./routes/CarList.svelte";
	import CarInfo from "./routes/CarInfo.svelte";

	import NotFound from "./routes/NotFound.svelte";
	import AllReservations from "./routes/mod&Admin/AllReservations.svelte";
	import MyReservations from "./routes/MyReservations.svelte";
	import ReservInfo from "./routes/ReservInfo.svelte";
	import TimeSimulation from "./routes/mod&Admin/TimeSimulation.svelte";
	import TermsConditions from "./routes/TermsConditions.svelte";
</script>

<Tailwindcss />
<main id="main">
	<Header />
	<Router
		routes={{
			"/": Home,
			"/login": Login,
			"/register": Register,
			"/adminPanel": AdminPanel,
			"/carList": CarList,
			"/carInfo/:id": CarInfo,
			"/allReservations": AllReservations,
			"/myReservations": MyReservations,
			"/reservInfo/:id": ReservInfo,
			"/timeSimulation": TimeSimulation,
			"/termsConditions": TermsConditions,
			"*": NotFound,
		}}
	/>
	<Footer />
</main>

<style>
	main {
		background-color: rgb(17, 24, 39);
		width: 100%;
		min-height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
</style>
