<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-blue-500 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-black">
                        <!-- Project Button -->
                        <button id="openModalButton" class="bg-white hover:bg-gray-200 text-blue-500 font-bold py-2 px-4 rounded" data-toggle="modal" data-target="#projectModal">
                            Project
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("You're logged in!") }}
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        @if(isset($environments))
                            @if ($environments)
                                <h3>Environments:</h3>
                                <div class="table-responsive">
                                    <table class="table table-striped table-dark">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Environment</th>
                                                <th scope="col">API Endpoint</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($environments as $index => $environment)
                                                <tr>
                                                    <th scope="row">{{ $index + 1 }}</th>
                                                    <td>{{ $environment }}</td>
                                                    <td>
                                                        <a href="{{ url('/api/environments/' . $environment) }}" target="_blank">
                                                            {{ url('/api/environments/' . $environment) }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>No environments found.</p>
                            @endif
                        @else
                            <p>Environments data is not available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectModalLabel">Select Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="projectSelect">Project</label>
                            <select id="projectSelect" class="form-control">
                                <option value="" selected disabled>Select a Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="nextButton" onclick="showEnvironments()">Next</button>
                    </div>

                </div>
            </div>
        </div>
    </x-app-layout>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('nextButton').addEventListener('click', function() {
            // Add your logic for the next button here
            console.log('Next button clicked');
        });
        
   
    function showEnvironments() {
        // Show the environments table section
        document.getElementById('environmentsTable').style.display = 'block';

        // Optionally, you can load data via AJAX here if needed
        // Example AJAX call:
        /*
        $.ajax({
            url: '/api/environments', // Replace with your API endpoint
            method: 'GET',
            success: function(response) {
                // Example: Populate environments table rows dynamically
                let environmentsBody = document.getElementById('environmentsBody');
                environmentsBody.innerHTML = '';
                response.environments.forEach((environment, index) => {
                    let row = `<tr>
                        <th scope="row">${index + 1}</th>
                        <td>${environment.name}</td>
                        <td>
                            <a href="/api/environments/${environment.id}" target="_blank">
                                /api/environments/${environment.id}
                            </a>
                        </td>
                    </tr>`;
                    environmentsBody.innerHTML += row;
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching environments:', error);
            }
        });
        */
    }
</script>

</body>
</html>
