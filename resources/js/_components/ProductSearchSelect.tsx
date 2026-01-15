import AsyncSelect from "react-select/async";
import { components, OptionProps } from "react-select";
import ProductSearchController from "@/actions/App/Http/Controllers/ProductSearchController";
import { debounce } from "es-toolkit/function";
import { daisyUISelectStyles } from "./reactSelectStyles";

async function loadOptions(inputValue: string, params?: Record<string, unknown>) {
    if (!inputValue) {
        return [];
    }

    try {
        const searchParams = new URLSearchParams();
        searchParams.append('term', inputValue);

        if (params && Object.keys(params).length > 0) {
            for (const key in params) {
                searchParams.append(key, params[key] as string);
            }
        }

        const response = await fetch(`${ProductSearchController().url}?${searchParams}`);
        const data = await response.json();

        return data.map((product: any) => ({
            thumb_url: product.thumb_url,
            value: product.id,
            label: product.text,
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
}, 500);

const Option = (props: OptionProps<any>) => {
    const thumburl = props.data.thumb_url = props.data.thumb_url || 'https://placehold.co/40x40?text=No+image';

    return (
        <components.Option {...props} className="flex! items-center gap-2">
            <img src={thumburl} width={40} height={40} />
            <span>{props.data.label}</span>
        </components.Option>
    );
};

export default function ProductSearchSelect({ name, placeholder, params }: {
    name: string;
    placeholder: string;
    params?: Record<string, unknown>
}) {
    return (
        <AsyncSelect
            loadOptions={inputValue => new Promise((resolve: any) => debouncedLoadOptions({ inputValue, params, callback: resolve }))}
            isSearchable
            placeholder={placeholder}
            loadingMessage={() => "Searching..."}
            noOptionsMessage={({ inputValue }) =>
                inputValue ? `No Products found for "${inputValue}"` : "Start typing to search..."
            }
            name={name}
            components={{ Option }}
            styles={daisyUISelectStyles}
        />
    );
}
