<div {{ $attributes->merge(['class' => 'overflow-x-auto']) }}>
    <table class="w-full text-sm border border-slate-500">
        <thead>
            <tr class="bg-gray-300">
                <th class="p-1 border border-slate-500">{{ __('Discussion title') }}</th>
                <th class="p-1 border border-slate-500">{{ __('Discussion participants') }}</th>
                <th class="p-1 border border-slate-500">{{ __('Initial message') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Short Job Names') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]') }}</td>
                <td class="p-3 border flow border-slate-500">
                    <p>{{ __('Names of Opportunities in CurrentRMS are not suitable to be used on paperwork, on roadcases, or in emails. It\'s also not appropriate for staff working on this Job to “make up” a Job Name at their discretion, ortr to have several different Job Names in use.') }}</p>
                    <p>{{ __('The Account Manager defines the Short Job Name early in the process that is used any time this Job is referred to. ') }}</p>
                    <p>{{ __('In a message below, the Account Manager will define the Short Job Name to use for this Job.') }}</p>
                </td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Sub-hires') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Sophie Grimoldi') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion lists quotes from Suppliers for sub-hired equipment from this Job, and notes from the Account Manager about sub-hires.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Quote review') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion is for talk between the Account Manager and Senior Account Manager / SAM to discuss the approach to quoting this Job.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Job Codes') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Nilanka; Paige Bradsmith') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion tracks when Job Codes are created in Xero and QB Time, and by whom.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Invoicing') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Nilanka') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion is used to indicate the invoicing and payment terms agreed with the Client.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Spare Fixtures') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Paige Bradsmith; Michael Parsons') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion specifies and justifies the spare fixtures added to this Job.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Gasses') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Paige Bradsmith') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion specifies the gasses required for this Job.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Other people\'s stuff') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Oliver Rumpf') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion has details about other people\'s stuff travelling on MPH trucks for this Job. For example, merch, other production departments, the Promoter Rep\'s drawers case, and similar.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('MPH Crew qualifications') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Paige Bradsmith') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion specifies the skills and qualifications MPH crew assigned to this Job must have as a minimum.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Touring Crew Info') }}</td>
                <td class="p-3 border border-slate-500">{{ __('Paige Bradsmith') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion logs the details of the touring Lighting crew on this Job, that is, those appointed by the Artist / Artist management, separate to MPH crew.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('MPH Crew info') }}</td>
                <td class="p-3 border border-slate-500">{{ __('Paige Bradsmith; Sophie Grimoldi') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion logs which crew are assigned to this Job. As necessary, changes will be logged with a new message that shows the full updated crew.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Local Crew info') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Paige Bradsmith; Sophie Grimoldi') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion indicates who will be organising Local Crew for this Job. If MPH is organising this crew, this will include the number of Local Crew required for each shift.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Info from LD') }}</td>
                <td class="p-3 border border-slate-500">{{ __('Paige Bradsmith') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion logs info provided by the LD for the Job, including info about the latest lighting plot, substitutions, fixture modes and console software versions. Some of this info may come from people other than the LD (for example, a touring Operator), but it\'s still recorded in this Discussion.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Production Trucking') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Paige Bradsmith') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion records who will provide Production Trucking for this Job, and how many feet of truck space are provided / who that space is shared with.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Crew Ground Transport') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Paige Bradsmith; Sophie Grimoldi') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion stores information about Ground transport for this Job.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('MPH Crew accommodation') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Paige Bradsmith; Sophie Grimoldi') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion stores information about crew accommodation for this Job.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('MPH Crew flights') }}</td>
                <td class="p-3 border border-slate-500">{{ __('[Opportunity Owner as selected]; Paige Bradsmith; Sophie Grimoldi') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion stores information about crew flights for this Job.') }}</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-500">{{ __('Picking List') }}</td>
                <td class="p-3 border border-slate-500">{{ __('Paige Bradsmith; Oliver Rumpf; Sophie Grimoldi') }}</td>
                <td class="p-3 border border-slate-500">{{ __('This Discussion is where the Production Administrator indicates when a Job is ready to be Picked, and if there are any special notes about Picking.') }}</td>
            </tr>
        </tbody>
    </table>
</div>
