import AsyncSelect from "react-select/async";
import OpportunitySearchController from "@/actions/App/Http/Controllers/OpportunitySearchController";
import { debounce } from "es-toolkit/function";

async function loadOptions(inputValue: string, params?: Record<string, unknown>) {
    if (!inputValue) {
        return [];
    }

    try {
        const searchParams = new URLSearchParams();
        searchParams.append('term', inputValue);

        if (params && Object.keys(params).length > 0) {
            for (const key in params) {
                searchParams.append(key, params[ key ] as string);
            }
        }

        console.log(`${OpportunitySearchController().url}?${searchParams}`);

        const response = await fetch(`${OpportunitySearchController().url}?${searchParams}`);
        const data = await response.json();

        return data.map((opportunity: any) => ({
            value: opportunity.id,
            label: opportunity.subject,
        }));
    } catch (error) {
        console.error(error);
        return [];
    }
};

const debouncedLoadOptions = debounce(({ inputValue, params, callback }: {
    inputValue: string;
    params?: Record<string, unknown>;
    callback: (options: any[]) => void;
}) => {
    loadOptions(inputValue, params).then(callback);
}, 500)

export default function OpportunitySearchSelect({ name, placeholder, params }: {
    name: string;
    placeholder: string;
    params?: Record<string, unknown>
}) {
    return (
        <AsyncSelect
            loadOptions={ inputValue => new Promise((resolve: any) => debouncedLoadOptions({ inputValue, params, callback: resolve })) }
            isSearchable
            placeholder={ placeholder }
            loadingMessage={ () => "Searching..." }
            noOptionsMessage={ ({ inputValue }) =>
                inputValue ? `No Opportunities found for "${inputValue}"` : "Start typing to search..."
            }
            name={ name }
        />
    );
}
