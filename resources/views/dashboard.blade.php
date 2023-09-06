<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Hello there {{ auth()->user()->name }}
                </div>
            </div>
        </div>

        @if(auth()->user()->subscriptionPlan === null)
        <div class="max-w-7xl mx-auto mt-10 sm:px-6 lg:px-8" id="plans">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Seems you're not set up with a subscription yet. <br>
                    You need one to be able to invest on the platfrom. Please select one of the following to continue
                </div>
                <div class="grid grid-cols-4 gap-2 p-10" id="plan-grid">
                    <!-- Add Plans Here -->
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        $(document).ready(() => {
            $(document).on('click', '.select-plan', (e) => {
                e.preventDefault();
                const id = e.target.getAttribute("id");
                subscribe(id);
            });

            console.log("{{ auth()->user()->subscriptioPlan }}");

            fetch("{{ route('subscription.plans') }}", {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(response => {
                    console.log(response.data);
                    response.data?.map(plan => {
                        $('#plan-grid').append(`
                        <div class="max-w-sm rounded overflow-hidden shadow-lg">
                            <img class="w-full" src={{ asset("/images/card-top.jpg") }} alt="Sunset in the mountains">
                            <div class="px-6 py-4">
                                <div class="text-xl font-bold text-white mb-2">${plan.name}</div>
                                <p class="text-l text-white mb-2">Ksh. ${plan.price} for ${parseInt(plan.validity/30)} months</p>
                                <p class="text-md text-gray-700 text-base">${plan.description}</p>
                            </div>
                            <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 m-4 rounded select-plan" id="${plan.id}">Select</button>
                        </div>`);
                    });
                })
                .catch(err => console.log(err));
        });

        function subscribe(selectedPlan) {
            if (confirm("Are you sure you want to subscribe?")){
                fetch("{{ route('subscription.subscribe') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            _token: "{{ csrf_token() }}",
                            plan_id: selectedPlan
                        })
                    })
                    .then(res => res.json())
                    .then(response => {
                        alert(response.message);
                        if (response.success) $("#plans").css("display", "none");
                    })
                    .catch(err => console.log(err));
            }
        }

    </script>
</x-app-layout>