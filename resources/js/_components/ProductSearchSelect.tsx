import AsyncSelect from "react-select/async";
import { components, OptionProps } from "react-select";
import ProductSearchController from "@/actions/App/Http/Controllers/ProductSearchController";
import { debounce } from "es-toolkit/function";
import { daisyUISelectStyles } from "../reactSelectStyles";
import { useState } from "react";
import { Product } from "@/types";

export type ProductOption = { value: number; label: string; product: Product };

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

        return data.map((product: Product) => ({
            value: product.id,
            label: product.name,
            product,
        }));
    } catch (error) {
        console.error(error);
        return [];
    }
};

const debouncedLoadOptions = debounce(({ inputValue, params, callback }: {
    inputValue: string;
    params?: Record<string, unknown>;
    callback: (options: ProductOption[]) => void;
}) => {
    loadOptions(inputValue, params).then(callback);
}, 500);

const Option = (props: OptionProps<ProductOption>) => {
    const thumburl = props.data.product.icon?.thumb_url || 'https://placehold.co/40x40?text=No+image';

    return (
        <components.Option {...props} className="flex! items-center gap-2">
            <img src={thumburl} width={40} height={40} />
            <span>{props.data.label}</span>
        </components.Option>
    );
};

export default function ProductSearchSelect({ name, placeholder, params, clearOnSelect = false, onChange }: {
    name: string;
    placeholder: string;
    params?: Record<string, unknown>;
    clearOnSelect?: boolean;
    onChange?: (option: ProductOption | null) => void;
}) {
    const [resetKey, setResetKey] = useState<number>(0);

    const handleChange = (option: ProductOption | null) => {
        onChange?.(option);

        if (clearOnSelect) {
            setResetKey(prev => prev + 1);
        }
    }

    return (
        <AsyncSelect
            key={resetKey}
            loadOptions={inputValue => new Promise((resolve: (options: ProductOption[]) => void) => debouncedLoadOptions({ inputValue, params, callback: resolve }))}
            isSearchable
            blurInputOnSelect
            placeholder={placeholder}
            loadingMessage={() => "Searching..."}
            noOptionsMessage={({ inputValue }) =>
                inputValue ? `No Products found for "${inputValue}"` : "Start typing to search..."
            }
            name={name}
            components={{ Option }}
            styles={daisyUISelectStyles}
            onChange={handleChange}
        />
    );
}
