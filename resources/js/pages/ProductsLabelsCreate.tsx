import ProductFloatingGenerateLabels from "@/_components/ProductFloatingGenerateLabels";
import ProductGenerateLabels from "@/_components/ProductGenerateLabels";
import ProductList from "@/_components/ProductList";
import ProductSearchSelect, { ProductOption } from "@/_components/ProductSearchSelect";
import ProductsLabelsGenerateController from "@/actions/App/Http/Controllers/ProductsLabelsGenerateController";
import { Product, SharedData } from "@/types";
import { Head, router, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function ProductsLabelsCreate() {
    const { title, errors } = usePage<SharedData>().props;
    const [products, setProducts] = useState<Product[]>([
        {
            "id": 2013,
            "name": "5-Pin Adapter Cable - Male to 3-Pin Female",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1307/thumb/2013.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCVZPMJUZ5%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122224Z&X-Amz-Expires=723&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEE8aCXVzLWVhc3QtMSJHMEUCIC5UcKs9UNZhgZNLFgNmzaxx%2BLNrPx02hejk9PWCzfuZAiEA%2FeXZafu3S1cn6OgA1Pgmt2u%2Fj0cMGe4LfdEDPDBYo4sqswUIFxAAGgw1NTk2MDM3MDMzNjUiDHCJLvY7FnrD0F3LgyqQBaaYep%2BeeC2mL8RaFzKhD8q%2FXqlCpCyecZ1nuoNobt9C7%2FUYqTxLgXGl4UxaIPEeQXqxN72h3MNF%2FS6R%2Bs%2FeKX5I1AiUX0cUs7tI4wRDE8IoUGFRhM%2BDdsMgWKoLv40P7utVhgZX%2F1NtiTLM%2F4WwLbdZ0O0nXgk1xJssD9NXZ5Kf%2B9MtkxL3lxUNoaMZHUTB1XxUQ0SXhqixPpEM3ujDujPqumpf5%2FJOOSCOJIcvxMKwBEOV7PKzo%2Bw%2Ba1rRAumfU4zK91coRf9EZrpSSMCFBIl5wniFgwbd0qQEWOQA87htqiCru%2FEssgqFQ9kGjqcfHAPmWk6dMz2zyJwYJ0GA1zKJqAkXLMhmI7t22fBf5ppu5V4HWQXsrgzFauDjW1vl2ZBXPLTb%2B0gl0zy3uh5w6XHhmdGOBOY5A6D7cRwtTlZ07XsyfrESu50w9rNyNiyxTRJOJdENVC4zUJJDW%2Bul1k17pfVDLd%2F2XIwKxjWI%2F2MwACbkLtJowxMqxQqxACB082KqD4R1DvWUeG9bRALlxWQ5lcKig13s4xMBHFOv3hf%2BB7OT2%2FV0kEJ%2Fo6IUzyMMacsY7heRg20sooMY57GOc1YwFTaIn5iKYzWwOhcMbTXJGfthQvBZpNmw83ewQKds5GNdehyWWKp0ftzI3qxmwJBcFJjAPNyMaTAOgZJVL9mrgrTYRf9lfeSb3YTanJxLwCMdjs6VKK2dGlNML7KOHWFWbXW3eGESWMdMNQBnJF4F4bNeo0oyc%2BZ8HmZzebTTMBzpqtcu2xYazxoreYRgs7fYwAhT%2FLd1lXrmSePru0zTauXNKM8bBY8HfCOO%2FgovduB80ZOoGrTC7MJ1458AzXwfk8Nh9Se2qbNp5wHCMvB6MLHrv9AGOrEBhEKUw6tz4Tij0L6SrZEpXd8ZleirhhTg7jkHnSgG%2FPQjEcuUZa9sQW6CIEQ1jNQSEhaUwW5YeYlB5AVlEc3UtIuNx0Wyp0ZkMmrgABGRdNAK688478jKlVowa5gc4wTE3kcqvj4e5uat%2ByQ2f0v9R1xd7JRhiPAfpzJV4P1dQAcSq3Ut568CQwHgKW8HUXm%2FRIWvhtMgs9fg7hQrV50ADMaVjP%2B0dMemgm3I2qbIVdLT&X-Amz-SignedHeaders=host&X-Amz-Signature=696f56201709777cc49309129f6d66afc0bd7500e58b3b4bb790e84117d61e4a",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1307/original/2013.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCVZPMJUZ5%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122224Z&X-Amz-Expires=723&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEE8aCXVzLWVhc3QtMSJHMEUCIC5UcKs9UNZhgZNLFgNmzaxx%2BLNrPx02hejk9PWCzfuZAiEA%2FeXZafu3S1cn6OgA1Pgmt2u%2Fj0cMGe4LfdEDPDBYo4sqswUIFxAAGgw1NTk2MDM3MDMzNjUiDHCJLvY7FnrD0F3LgyqQBaaYep%2BeeC2mL8RaFzKhD8q%2FXqlCpCyecZ1nuoNobt9C7%2FUYqTxLgXGl4UxaIPEeQXqxN72h3MNF%2FS6R%2Bs%2FeKX5I1AiUX0cUs7tI4wRDE8IoUGFRhM%2BDdsMgWKoLv40P7utVhgZX%2F1NtiTLM%2F4WwLbdZ0O0nXgk1xJssD9NXZ5Kf%2B9MtkxL3lxUNoaMZHUTB1XxUQ0SXhqixPpEM3ujDujPqumpf5%2FJOOSCOJIcvxMKwBEOV7PKzo%2Bw%2Ba1rRAumfU4zK91coRf9EZrpSSMCFBIl5wniFgwbd0qQEWOQA87htqiCru%2FEssgqFQ9kGjqcfHAPmWk6dMz2zyJwYJ0GA1zKJqAkXLMhmI7t22fBf5ppu5V4HWQXsrgzFauDjW1vl2ZBXPLTb%2B0gl0zy3uh5w6XHhmdGOBOY5A6D7cRwtTlZ07XsyfrESu50w9rNyNiyxTRJOJdENVC4zUJJDW%2Bul1k17pfVDLd%2F2XIwKxjWI%2F2MwACbkLtJowxMqxQqxACB082KqD4R1DvWUeG9bRALlxWQ5lcKig13s4xMBHFOv3hf%2BB7OT2%2FV0kEJ%2Fo6IUzyMMacsY7heRg20sooMY57GOc1YwFTaIn5iKYzWwOhcMbTXJGfthQvBZpNmw83ewQKds5GNdehyWWKp0ftzI3qxmwJBcFJjAPNyMaTAOgZJVL9mrgrTYRf9lfeSb3YTanJxLwCMdjs6VKK2dGlNML7KOHWFWbXW3eGESWMdMNQBnJF4F4bNeo0oyc%2BZ8HmZzebTTMBzpqtcu2xYazxoreYRgs7fYwAhT%2FLd1lXrmSePru0zTauXNKM8bBY8HfCOO%2FgovduB80ZOoGrTC7MJ1458AzXwfk8Nh9Se2qbNp5wHCMvB6MLHrv9AGOrEBhEKUw6tz4Tij0L6SrZEpXd8ZleirhhTg7jkHnSgG%2FPQjEcuUZa9sQW6CIEQ1jNQSEhaUwW5YeYlB5AVlEc3UtIuNx0Wyp0ZkMmrgABGRdNAK688478jKlVowa5gc4wTE3kcqvj4e5uat%2ByQ2f0v9R1xd7JRhiPAfpzJV4P1dQAcSq3Ut568CQwHgKW8HUXm%2FRIWvhtMgs9fg7hQrV50ADMaVjP%2B0dMemgm3I2qbIVdLT&X-Amz-SignedHeaders=host&X-Amz-Signature=e3c20716d0963ebc5a4b9fba8c8e0bbd49fc6843119092723853db985d13d502"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "No",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": "Yes"
            }
        },
        {
            "id": 1208,
            "name": "5-Pin Cable - 3m",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1318/thumb/2386.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCTL4WTW2K%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122230Z&X-Amz-Expires=20080&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFQaCXVzLWVhc3QtMSJHMEUCIHltGBXG5cB50tn9X%2FvYmGipi2R6wqKcuZbD6zS%2FsO6cAiEAiP%2BHEFovXV4A5SXPapfscVig0ff8o2pZIsxlSZFS7QUqtAUIHRAAGgw1NTk2MDM3MDMzNjUiDDn7tMe6b2OQPHPOniqRBXKtC%2BtiINWHHzY6dVRDUhaxQ9mXprxpN5%2BLAieRbDxn887JmVfYz2FCGImRgetSSsfQoTEm%2BTo%2BRVIujYCso3TSephnlpm%2FjP%2BGkHtPIywyCnJOesYUGf3UoVLWigo5R%2Fz84Y0FwLIyoZskfNvtnpTljzTu%2Fwy%2Bn2KnuDbiHsnCFTant5z3Lyr8YOenJzmQjj86DNKoQwKj9bPiPXvmWgOzU%2BVD1BOsPDbTUszuUwIb6xnhbFRIndrPg1oE1hk7rPZb71B71LcQff9vV2MbW7YBDnj%2BHgK4Pg9XMdIz66keu70DldK8Ljij1LSs3zVSwposcE%2FDWTiyLpS0LvMJPoy3uo%2Ba2sgswfOmip2vMKIyV%2BU%2BjGngcp9fRTFbz28ZSHXi7uUnHMcocn6PVKX6%2F%2BUWM3BOmYD%2F2KsCjQxNLKsucvWenl0tIXZTNpSjL%2F4xUIVukq3ztYH0yNHrK2l0WGiNudrE5tSFgPs9c%2FiEpiDO5D6gXgZ%2BlKVbaJSDryCCu9jCavhRh8aRh3mWZ1GIOh5HTTHjPLE3hTnMx7Ycytknh%2F%2FByO7b9R%2F4oTP44NNxO4DsjT4SwOExpFxJ3pmlJzhR7VBgjfLnqgfgCzDnWNhkkFrcPU4IYM17arqk7KK0yBguWidGacrS8ey1a2NdIlR%2BCcVzazD55hbLUfxjXFkkv9rtXPx0QcDtb9jxzUAbRGngg%2BMmIhPthyCGat%2BJrczVHDF9tZo58HnwDaoGBwFIhdQWrqI9RPNQBz5zi%2Fn2EBO%2Fow45rvpMleeeIWX8dwM61fJMBhbYS1j8fbrw0AHE6R4UN8M3CXt9oGk6PJEqgWBdlfEjyKWVFPPwYTIiN3IppLLtoJhimzQxRivf44oBTTCmgsHQBjqxAVqdtEDomlrFnadXeFw0M07W0QNYItY%2Fpvckl2dB7CfiGdZW%2FL3rmNN8W%2FYsD82bsnkxQIf0J6LP1NLTQuHewNt93bRbOKkCCRDkyw%2BBqDptRHN6buFlKBtK06pFYiQFl%2FmEiJks%2BKJ9ZAtvjcnHnG%2F3TPtr5HVxunRUokT%2B3ok%2Bk%2F5NpxGF8%2F2CA%2FBLNbITYqFB2h9Z1%2F1MVkz8RZV2f9gjqWIC4i3xQjzGDQj2MD4ufg%3D%3D&X-Amz-SignedHeaders=host&X-Amz-Signature=6a191154c6b0629120356994e2839520fa54674cc11bacd237dc9f0af01c95f1",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1318/original/2386.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCTL4WTW2K%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122230Z&X-Amz-Expires=20080&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFQaCXVzLWVhc3QtMSJHMEUCIHltGBXG5cB50tn9X%2FvYmGipi2R6wqKcuZbD6zS%2FsO6cAiEAiP%2BHEFovXV4A5SXPapfscVig0ff8o2pZIsxlSZFS7QUqtAUIHRAAGgw1NTk2MDM3MDMzNjUiDDn7tMe6b2OQPHPOniqRBXKtC%2BtiINWHHzY6dVRDUhaxQ9mXprxpN5%2BLAieRbDxn887JmVfYz2FCGImRgetSSsfQoTEm%2BTo%2BRVIujYCso3TSephnlpm%2FjP%2BGkHtPIywyCnJOesYUGf3UoVLWigo5R%2Fz84Y0FwLIyoZskfNvtnpTljzTu%2Fwy%2Bn2KnuDbiHsnCFTant5z3Lyr8YOenJzmQjj86DNKoQwKj9bPiPXvmWgOzU%2BVD1BOsPDbTUszuUwIb6xnhbFRIndrPg1oE1hk7rPZb71B71LcQff9vV2MbW7YBDnj%2BHgK4Pg9XMdIz66keu70DldK8Ljij1LSs3zVSwposcE%2FDWTiyLpS0LvMJPoy3uo%2Ba2sgswfOmip2vMKIyV%2BU%2BjGngcp9fRTFbz28ZSHXi7uUnHMcocn6PVKX6%2F%2BUWM3BOmYD%2F2KsCjQxNLKsucvWenl0tIXZTNpSjL%2F4xUIVukq3ztYH0yNHrK2l0WGiNudrE5tSFgPs9c%2FiEpiDO5D6gXgZ%2BlKVbaJSDryCCu9jCavhRh8aRh3mWZ1GIOh5HTTHjPLE3hTnMx7Ycytknh%2F%2FByO7b9R%2F4oTP44NNxO4DsjT4SwOExpFxJ3pmlJzhR7VBgjfLnqgfgCzDnWNhkkFrcPU4IYM17arqk7KK0yBguWidGacrS8ey1a2NdIlR%2BCcVzazD55hbLUfxjXFkkv9rtXPx0QcDtb9jxzUAbRGngg%2BMmIhPthyCGat%2BJrczVHDF9tZo58HnwDaoGBwFIhdQWrqI9RPNQBz5zi%2Fn2EBO%2Fow45rvpMleeeIWX8dwM61fJMBhbYS1j8fbrw0AHE6R4UN8M3CXt9oGk6PJEqgWBdlfEjyKWVFPPwYTIiN3IppLLtoJhimzQxRivf44oBTTCmgsHQBjqxAVqdtEDomlrFnadXeFw0M07W0QNYItY%2Fpvckl2dB7CfiGdZW%2FL3rmNN8W%2FYsD82bsnkxQIf0J6LP1NLTQuHewNt93bRbOKkCCRDkyw%2BBqDptRHN6buFlKBtK06pFYiQFl%2FmEiJks%2BKJ9ZAtvjcnHnG%2F3TPtr5HVxunRUokT%2B3ok%2Bk%2F5NpxGF8%2F2CA%2FBLNbITYqFB2h9Z1%2F1MVkz8RZV2f9gjqWIC4i3xQjzGDQj2MD4ufg%3D%3D&X-Amz-SignedHeaders=host&X-Amz-Signature=c4f3e93a2d3c6902fc60eeed6dd528ddf1ad22b80f9d66a74c63af089833d05e"
            },
            "custom_fields": {
                "colour_coded_storage": "Yes",
                "nally_bin_storage": "Yes",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": "No"
            }
        },
        {
            "id": 1083,
            "name": "3-Phase Splitter 32A - Male to 2x Female (Double Outlet)",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1284/thumb/1083.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCTL4WTW2K%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122235Z&X-Amz-Expires=20075&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFQaCXVzLWVhc3QtMSJHMEUCIHltGBXG5cB50tn9X%2FvYmGipi2R6wqKcuZbD6zS%2FsO6cAiEAiP%2BHEFovXV4A5SXPapfscVig0ff8o2pZIsxlSZFS7QUqtAUIHRAAGgw1NTk2MDM3MDMzNjUiDDn7tMe6b2OQPHPOniqRBXKtC%2BtiINWHHzY6dVRDUhaxQ9mXprxpN5%2BLAieRbDxn887JmVfYz2FCGImRgetSSsfQoTEm%2BTo%2BRVIujYCso3TSephnlpm%2FjP%2BGkHtPIywyCnJOesYUGf3UoVLWigo5R%2Fz84Y0FwLIyoZskfNvtnpTljzTu%2Fwy%2Bn2KnuDbiHsnCFTant5z3Lyr8YOenJzmQjj86DNKoQwKj9bPiPXvmWgOzU%2BVD1BOsPDbTUszuUwIb6xnhbFRIndrPg1oE1hk7rPZb71B71LcQff9vV2MbW7YBDnj%2BHgK4Pg9XMdIz66keu70DldK8Ljij1LSs3zVSwposcE%2FDWTiyLpS0LvMJPoy3uo%2Ba2sgswfOmip2vMKIyV%2BU%2BjGngcp9fRTFbz28ZSHXi7uUnHMcocn6PVKX6%2F%2BUWM3BOmYD%2F2KsCjQxNLKsucvWenl0tIXZTNpSjL%2F4xUIVukq3ztYH0yNHrK2l0WGiNudrE5tSFgPs9c%2FiEpiDO5D6gXgZ%2BlKVbaJSDryCCu9jCavhRh8aRh3mWZ1GIOh5HTTHjPLE3hTnMx7Ycytknh%2F%2FByO7b9R%2F4oTP44NNxO4DsjT4SwOExpFxJ3pmlJzhR7VBgjfLnqgfgCzDnWNhkkFrcPU4IYM17arqk7KK0yBguWidGacrS8ey1a2NdIlR%2BCcVzazD55hbLUfxjXFkkv9rtXPx0QcDtb9jxzUAbRGngg%2BMmIhPthyCGat%2BJrczVHDF9tZo58HnwDaoGBwFIhdQWrqI9RPNQBz5zi%2Fn2EBO%2Fow45rvpMleeeIWX8dwM61fJMBhbYS1j8fbrw0AHE6R4UN8M3CXt9oGk6PJEqgWBdlfEjyKWVFPPwYTIiN3IppLLtoJhimzQxRivf44oBTTCmgsHQBjqxAVqdtEDomlrFnadXeFw0M07W0QNYItY%2Fpvckl2dB7CfiGdZW%2FL3rmNN8W%2FYsD82bsnkxQIf0J6LP1NLTQuHewNt93bRbOKkCCRDkyw%2BBqDptRHN6buFlKBtK06pFYiQFl%2FmEiJks%2BKJ9ZAtvjcnHnG%2F3TPtr5HVxunRUokT%2B3ok%2Bk%2F5NpxGF8%2F2CA%2FBLNbITYqFB2h9Z1%2F1MVkz8RZV2f9gjqWIC4i3xQjzGDQj2MD4ufg%3D%3D&X-Amz-SignedHeaders=host&X-Amz-Signature=026acdad31ba9e81696fba2f95f2cf24f1c8e3a55d3ad7e9bed8a9ea0eecc936",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1284/original/1083.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCTL4WTW2K%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122235Z&X-Amz-Expires=20075&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFQaCXVzLWVhc3QtMSJHMEUCIHltGBXG5cB50tn9X%2FvYmGipi2R6wqKcuZbD6zS%2FsO6cAiEAiP%2BHEFovXV4A5SXPapfscVig0ff8o2pZIsxlSZFS7QUqtAUIHRAAGgw1NTk2MDM3MDMzNjUiDDn7tMe6b2OQPHPOniqRBXKtC%2BtiINWHHzY6dVRDUhaxQ9mXprxpN5%2BLAieRbDxn887JmVfYz2FCGImRgetSSsfQoTEm%2BTo%2BRVIujYCso3TSephnlpm%2FjP%2BGkHtPIywyCnJOesYUGf3UoVLWigo5R%2Fz84Y0FwLIyoZskfNvtnpTljzTu%2Fwy%2Bn2KnuDbiHsnCFTant5z3Lyr8YOenJzmQjj86DNKoQwKj9bPiPXvmWgOzU%2BVD1BOsPDbTUszuUwIb6xnhbFRIndrPg1oE1hk7rPZb71B71LcQff9vV2MbW7YBDnj%2BHgK4Pg9XMdIz66keu70DldK8Ljij1LSs3zVSwposcE%2FDWTiyLpS0LvMJPoy3uo%2Ba2sgswfOmip2vMKIyV%2BU%2BjGngcp9fRTFbz28ZSHXi7uUnHMcocn6PVKX6%2F%2BUWM3BOmYD%2F2KsCjQxNLKsucvWenl0tIXZTNpSjL%2F4xUIVukq3ztYH0yNHrK2l0WGiNudrE5tSFgPs9c%2FiEpiDO5D6gXgZ%2BlKVbaJSDryCCu9jCavhRh8aRh3mWZ1GIOh5HTTHjPLE3hTnMx7Ycytknh%2F%2FByO7b9R%2F4oTP44NNxO4DsjT4SwOExpFxJ3pmlJzhR7VBgjfLnqgfgCzDnWNhkkFrcPU4IYM17arqk7KK0yBguWidGacrS8ey1a2NdIlR%2BCcVzazD55hbLUfxjXFkkv9rtXPx0QcDtb9jxzUAbRGngg%2BMmIhPthyCGat%2BJrczVHDF9tZo58HnwDaoGBwFIhdQWrqI9RPNQBz5zi%2Fn2EBO%2Fow45rvpMleeeIWX8dwM61fJMBhbYS1j8fbrw0AHE6R4UN8M3CXt9oGk6PJEqgWBdlfEjyKWVFPPwYTIiN3IppLLtoJhimzQxRivf44oBTTCmgsHQBjqxAVqdtEDomlrFnadXeFw0M07W0QNYItY%2Fpvckl2dB7CfiGdZW%2FL3rmNN8W%2FYsD82bsnkxQIf0J6LP1NLTQuHewNt93bRbOKkCCRDkyw%2BBqDptRHN6buFlKBtK06pFYiQFl%2FmEiJks%2BKJ9ZAtvjcnHnG%2F3TPtr5HVxunRUokT%2B3ok%2Bk%2F5NpxGF8%2F2CA%2FBLNbITYqFB2h9Z1%2F1MVkz8RZV2f9gjqWIC4i3xQjzGDQj2MD4ufg%3D%3D&X-Amz-SignedHeaders=host&X-Amz-Signature=682ac5f96c64a44c1008c5b88a254e93f132896fd2d91e0c6307543a1bf0fd4d"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "Yes",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": "No"
            }
        },
        {
            "id": 1644,
            "name": "Black Drape - 3.0m x 7.0m",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/141/thumb/backdrop_stand_black_1_1_1_2.jpg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCVZPMJUZ5%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122245Z&X-Amz-Expires=702&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEE8aCXVzLWVhc3QtMSJHMEUCIC5UcKs9UNZhgZNLFgNmzaxx%2BLNrPx02hejk9PWCzfuZAiEA%2FeXZafu3S1cn6OgA1Pgmt2u%2Fj0cMGe4LfdEDPDBYo4sqswUIFxAAGgw1NTk2MDM3MDMzNjUiDHCJLvY7FnrD0F3LgyqQBaaYep%2BeeC2mL8RaFzKhD8q%2FXqlCpCyecZ1nuoNobt9C7%2FUYqTxLgXGl4UxaIPEeQXqxN72h3MNF%2FS6R%2Bs%2FeKX5I1AiUX0cUs7tI4wRDE8IoUGFRhM%2BDdsMgWKoLv40P7utVhgZX%2F1NtiTLM%2F4WwLbdZ0O0nXgk1xJssD9NXZ5Kf%2B9MtkxL3lxUNoaMZHUTB1XxUQ0SXhqixPpEM3ujDujPqumpf5%2FJOOSCOJIcvxMKwBEOV7PKzo%2Bw%2Ba1rRAumfU4zK91coRf9EZrpSSMCFBIl5wniFgwbd0qQEWOQA87htqiCru%2FEssgqFQ9kGjqcfHAPmWk6dMz2zyJwYJ0GA1zKJqAkXLMhmI7t22fBf5ppu5V4HWQXsrgzFauDjW1vl2ZBXPLTb%2B0gl0zy3uh5w6XHhmdGOBOY5A6D7cRwtTlZ07XsyfrESu50w9rNyNiyxTRJOJdENVC4zUJJDW%2Bul1k17pfVDLd%2F2XIwKxjWI%2F2MwACbkLtJowxMqxQqxACB082KqD4R1DvWUeG9bRALlxWQ5lcKig13s4xMBHFOv3hf%2BB7OT2%2FV0kEJ%2Fo6IUzyMMacsY7heRg20sooMY57GOc1YwFTaIn5iKYzWwOhcMbTXJGfthQvBZpNmw83ewQKds5GNdehyWWKp0ftzI3qxmwJBcFJjAPNyMaTAOgZJVL9mrgrTYRf9lfeSb3YTanJxLwCMdjs6VKK2dGlNML7KOHWFWbXW3eGESWMdMNQBnJF4F4bNeo0oyc%2BZ8HmZzebTTMBzpqtcu2xYazxoreYRgs7fYwAhT%2FLd1lXrmSePru0zTauXNKM8bBY8HfCOO%2FgovduB80ZOoGrTC7MJ1458AzXwfk8Nh9Se2qbNp5wHCMvB6MLHrv9AGOrEBhEKUw6tz4Tij0L6SrZEpXd8ZleirhhTg7jkHnSgG%2FPQjEcuUZa9sQW6CIEQ1jNQSEhaUwW5YeYlB5AVlEc3UtIuNx0Wyp0ZkMmrgABGRdNAK688478jKlVowa5gc4wTE3kcqvj4e5uat%2ByQ2f0v9R1xd7JRhiPAfpzJV4P1dQAcSq3Ut568CQwHgKW8HUXm%2FRIWvhtMgs9fg7hQrV50ADMaVjP%2B0dMemgm3I2qbIVdLT&X-Amz-SignedHeaders=host&X-Amz-Signature=89b987b80c13e1aeab29527fbccabd7a17904c131f8104dcfc9fa9666ee77a38",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/141/original/backdrop_stand_black_1_1_1_2.jpg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCVZPMJUZ5%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122245Z&X-Amz-Expires=702&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEE8aCXVzLWVhc3QtMSJHMEUCIC5UcKs9UNZhgZNLFgNmzaxx%2BLNrPx02hejk9PWCzfuZAiEA%2FeXZafu3S1cn6OgA1Pgmt2u%2Fj0cMGe4LfdEDPDBYo4sqswUIFxAAGgw1NTk2MDM3MDMzNjUiDHCJLvY7FnrD0F3LgyqQBaaYep%2BeeC2mL8RaFzKhD8q%2FXqlCpCyecZ1nuoNobt9C7%2FUYqTxLgXGl4UxaIPEeQXqxN72h3MNF%2FS6R%2Bs%2FeKX5I1AiUX0cUs7tI4wRDE8IoUGFRhM%2BDdsMgWKoLv40P7utVhgZX%2F1NtiTLM%2F4WwLbdZ0O0nXgk1xJssD9NXZ5Kf%2B9MtkxL3lxUNoaMZHUTB1XxUQ0SXhqixPpEM3ujDujPqumpf5%2FJOOSCOJIcvxMKwBEOV7PKzo%2Bw%2Ba1rRAumfU4zK91coRf9EZrpSSMCFBIl5wniFgwbd0qQEWOQA87htqiCru%2FEssgqFQ9kGjqcfHAPmWk6dMz2zyJwYJ0GA1zKJqAkXLMhmI7t22fBf5ppu5V4HWQXsrgzFauDjW1vl2ZBXPLTb%2B0gl0zy3uh5w6XHhmdGOBOY5A6D7cRwtTlZ07XsyfrESu50w9rNyNiyxTRJOJdENVC4zUJJDW%2Bul1k17pfVDLd%2F2XIwKxjWI%2F2MwACbkLtJowxMqxQqxACB082KqD4R1DvWUeG9bRALlxWQ5lcKig13s4xMBHFOv3hf%2BB7OT2%2FV0kEJ%2Fo6IUzyMMacsY7heRg20sooMY57GOc1YwFTaIn5iKYzWwOhcMbTXJGfthQvBZpNmw83ewQKds5GNdehyWWKp0ftzI3qxmwJBcFJjAPNyMaTAOgZJVL9mrgrTYRf9lfeSb3YTanJxLwCMdjs6VKK2dGlNML7KOHWFWbXW3eGESWMdMNQBnJF4F4bNeo0oyc%2BZ8HmZzebTTMBzpqtcu2xYazxoreYRgs7fYwAhT%2FLd1lXrmSePru0zTauXNKM8bBY8HfCOO%2FgovduB80ZOoGrTC7MJ1458AzXwfk8Nh9Se2qbNp5wHCMvB6MLHrv9AGOrEBhEKUw6tz4Tij0L6SrZEpXd8ZleirhhTg7jkHnSgG%2FPQjEcuUZa9sQW6CIEQ1jNQSEhaUwW5YeYlB5AVlEc3UtIuNx0Wyp0ZkMmrgABGRdNAK688478jKlVowa5gc4wTE3kcqvj4e5uat%2ByQ2f0v9R1xd7JRhiPAfpzJV4P1dQAcSq3Ut568CQwHgKW8HUXm%2FRIWvhtMgs9fg7hQrV50ADMaVjP%2B0dMemgm3I2qbIVdLT&X-Amz-SignedHeaders=host&X-Amz-Signature=55fc9bd67a9fa9d77f490e872ffe0d116e6fb42353daec3a06c1b8dd10278055"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": ""
            }
        },
        {
            "id": 1868,
            "name": "Robe Omega - Universal",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1023/thumb/Adobe_Express_-_file_28_.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZC22Z4TRTU%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122251Z&X-Amz-Expires=18250&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFMaCXVzLWVhc3QtMSJGMEQCIAvef8thu3D0%2Bq%2B8kc3AaQKF6HASw8w1yNSfiU8zpiURAiBJ6gw%2B4d5GpYwaxbGRLGP2dLjAEkZ1tZy40iYnH%2F9xiCqzBQgcEAAaDDU1OTYwMzcwMzM2NSIM5%2FiGHG1zJeqwlDunKpAFF9ypPcY7nXi5TrdrrkhNRnVc1l92IG1Uke41ktQcr6%2BnXpVLsHyL1Gs24hi4Qokf8WNIDEnsm7Msy7NoS7O%2FT0kDr7jZEHmFNWn27nJpF02fDhiqRJCS8YIiO5RnGXkUqUNHUMAp3cdjGD8pXjF92flLHiUU0lpjGiPtXXgwMwHhreX8jE8WFMMFWo%2F4ayB5CBtdnaVD80dHlMbRyOQp7s4ZKCNWYtl627HeeVg1CuvRcNB6TwfGOYkwpIYP%2F1hIg8Ld%2BTjagMuxqO9PnhPuvZAaTa4gZCKCES0UkvnTBK0ToPVEE%2BkQOmKf9PL97K4qoefFzOiMcCR4QINy1SRB06rx9eLgDGMJGC2oPJ%2B6aqGf5zg%2B6nt%2BcbPLob68nIx0ipjpbjetnTQnFPhLbmm2MzQa8AzHAXEjcKxsgdtvreWz03qAU1OJeHuVSfJ7I8DDVRn50XsTy%2B0zzfhg13AW2SWF5MO2Q5DunEaAFFT5n2Nm1xktA0XR47c572vyjTFLzkwvIdb7isdlUh%2B8X0YSAHNBgiMago6yKH84b531gERFDSKinNC7CT%2B7OAQhhRmUZHPrgCP8QsHC5gM9dybF6nw9jGq7jfBOZpBlJ2qmSxRiZjrNMx7mifFw0AVs52sI%2Bo0zbEeo%2BMNHa0lN8zNCqQgVr1xQcxN2KFIVWUxBXO0AQYcxajgx1mcqdqXwC3NpE1yykBDcdmU%2BU4QH1yoDVxiGx%2FgJgwTPlPUKuD4JL8oLwIthfULQo%2BurlOD1jdiQ9J3OMGfxGHX2RpjfGO4Sul001Iwa5xOy3eMJmjsAJ5qALUKyBgGGye2UQy88VWNGHGAGXDunMA2vyMcxTeIPqYaCvpIKBPRrynZlNQ0nrP8wle%2FA0AY6sgEvaRyMXqGtZbcqKy2QkSbf7%2B7VreZr4hf09NuuyDjLMzR%2FQTYYScDzxqV4zEokOG2eegIYs6pogcPHxgRd1LPSMZlj236ZpSsv6d6l2M5WJ%2FHPySYOnpJW%2BUEIlkc6Awav%2FYf%2BvnINFRhjn513m%2B4cp1SB8LPUUbE4aAXqqpT00Lcd7W3D2oVkVc5ZZyn%2F99EQWoSON9B5Vhv%2BvcehG5k2M50WuJ4lmWTnzlIC2Gu0G9Cq&X-Amz-SignedHeaders=host&X-Amz-Signature=fabc9a1435ef4fd6e6ccae57c74299fc25fd1c046dac4a828aceb71181ed1935",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1023/original/Adobe_Express_-_file_28_.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZC22Z4TRTU%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122251Z&X-Amz-Expires=18250&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFMaCXVzLWVhc3QtMSJGMEQCIAvef8thu3D0%2Bq%2B8kc3AaQKF6HASw8w1yNSfiU8zpiURAiBJ6gw%2B4d5GpYwaxbGRLGP2dLjAEkZ1tZy40iYnH%2F9xiCqzBQgcEAAaDDU1OTYwMzcwMzM2NSIM5%2FiGHG1zJeqwlDunKpAFF9ypPcY7nXi5TrdrrkhNRnVc1l92IG1Uke41ktQcr6%2BnXpVLsHyL1Gs24hi4Qokf8WNIDEnsm7Msy7NoS7O%2FT0kDr7jZEHmFNWn27nJpF02fDhiqRJCS8YIiO5RnGXkUqUNHUMAp3cdjGD8pXjF92flLHiUU0lpjGiPtXXgwMwHhreX8jE8WFMMFWo%2F4ayB5CBtdnaVD80dHlMbRyOQp7s4ZKCNWYtl627HeeVg1CuvRcNB6TwfGOYkwpIYP%2F1hIg8Ld%2BTjagMuxqO9PnhPuvZAaTa4gZCKCES0UkvnTBK0ToPVEE%2BkQOmKf9PL97K4qoefFzOiMcCR4QINy1SRB06rx9eLgDGMJGC2oPJ%2B6aqGf5zg%2B6nt%2BcbPLob68nIx0ipjpbjetnTQnFPhLbmm2MzQa8AzHAXEjcKxsgdtvreWz03qAU1OJeHuVSfJ7I8DDVRn50XsTy%2B0zzfhg13AW2SWF5MO2Q5DunEaAFFT5n2Nm1xktA0XR47c572vyjTFLzkwvIdb7isdlUh%2B8X0YSAHNBgiMago6yKH84b531gERFDSKinNC7CT%2B7OAQhhRmUZHPrgCP8QsHC5gM9dybF6nw9jGq7jfBOZpBlJ2qmSxRiZjrNMx7mifFw0AVs52sI%2Bo0zbEeo%2BMNHa0lN8zNCqQgVr1xQcxN2KFIVWUxBXO0AQYcxajgx1mcqdqXwC3NpE1yykBDcdmU%2BU4QH1yoDVxiGx%2FgJgwTPlPUKuD4JL8oLwIthfULQo%2BurlOD1jdiQ9J3OMGfxGHX2RpjfGO4Sul001Iwa5xOy3eMJmjsAJ5qALUKyBgGGye2UQy88VWNGHGAGXDunMA2vyMcxTeIPqYaCvpIKBPRrynZlNQ0nrP8wle%2FA0AY6sgEvaRyMXqGtZbcqKy2QkSbf7%2B7VreZr4hf09NuuyDjLMzR%2FQTYYScDzxqV4zEokOG2eegIYs6pogcPHxgRd1LPSMZlj236ZpSsv6d6l2M5WJ%2FHPySYOnpJW%2BUEIlkc6Awav%2FYf%2BvnINFRhjn513m%2B4cp1SB8LPUUbE4aAXqqpT00Lcd7W3D2oVkVc5ZZyn%2F99EQWoSON9B5Vhv%2BvcehG5k2M50WuJ4lmWTnzlIC2Gu0G9Cq&X-Amz-SignedHeaders=host&X-Amz-Signature=9e91f90f5464c07d5bbe187186d9ef1b518cff6db2a8f78fe091de90140ef7c3"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "No",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": "Yes"
            }
        },
        {
            "id": 2469,
            "name": "Base Plate Boom Pipe Adaptor - Suits 600mm Base Plate (Thick)",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1466/thumb/Image_from_Gboard_clipboard.jpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZC22Z4TRTU%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122257Z&X-Amz-Expires=18244&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFMaCXVzLWVhc3QtMSJGMEQCIAvef8thu3D0%2Bq%2B8kc3AaQKF6HASw8w1yNSfiU8zpiURAiBJ6gw%2B4d5GpYwaxbGRLGP2dLjAEkZ1tZy40iYnH%2F9xiCqzBQgcEAAaDDU1OTYwMzcwMzM2NSIM5%2FiGHG1zJeqwlDunKpAFF9ypPcY7nXi5TrdrrkhNRnVc1l92IG1Uke41ktQcr6%2BnXpVLsHyL1Gs24hi4Qokf8WNIDEnsm7Msy7NoS7O%2FT0kDr7jZEHmFNWn27nJpF02fDhiqRJCS8YIiO5RnGXkUqUNHUMAp3cdjGD8pXjF92flLHiUU0lpjGiPtXXgwMwHhreX8jE8WFMMFWo%2F4ayB5CBtdnaVD80dHlMbRyOQp7s4ZKCNWYtl627HeeVg1CuvRcNB6TwfGOYkwpIYP%2F1hIg8Ld%2BTjagMuxqO9PnhPuvZAaTa4gZCKCES0UkvnTBK0ToPVEE%2BkQOmKf9PL97K4qoefFzOiMcCR4QINy1SRB06rx9eLgDGMJGC2oPJ%2B6aqGf5zg%2B6nt%2BcbPLob68nIx0ipjpbjetnTQnFPhLbmm2MzQa8AzHAXEjcKxsgdtvreWz03qAU1OJeHuVSfJ7I8DDVRn50XsTy%2B0zzfhg13AW2SWF5MO2Q5DunEaAFFT5n2Nm1xktA0XR47c572vyjTFLzkwvIdb7isdlUh%2B8X0YSAHNBgiMago6yKH84b531gERFDSKinNC7CT%2B7OAQhhRmUZHPrgCP8QsHC5gM9dybF6nw9jGq7jfBOZpBlJ2qmSxRiZjrNMx7mifFw0AVs52sI%2Bo0zbEeo%2BMNHa0lN8zNCqQgVr1xQcxN2KFIVWUxBXO0AQYcxajgx1mcqdqXwC3NpE1yykBDcdmU%2BU4QH1yoDVxiGx%2FgJgwTPlPUKuD4JL8oLwIthfULQo%2BurlOD1jdiQ9J3OMGfxGHX2RpjfGO4Sul001Iwa5xOy3eMJmjsAJ5qALUKyBgGGye2UQy88VWNGHGAGXDunMA2vyMcxTeIPqYaCvpIKBPRrynZlNQ0nrP8wle%2FA0AY6sgEvaRyMXqGtZbcqKy2QkSbf7%2B7VreZr4hf09NuuyDjLMzR%2FQTYYScDzxqV4zEokOG2eegIYs6pogcPHxgRd1LPSMZlj236ZpSsv6d6l2M5WJ%2FHPySYOnpJW%2BUEIlkc6Awav%2FYf%2BvnINFRhjn513m%2B4cp1SB8LPUUbE4aAXqqpT00Lcd7W3D2oVkVc5ZZyn%2F99EQWoSON9B5Vhv%2BvcehG5k2M50WuJ4lmWTnzlIC2Gu0G9Cq&X-Amz-SignedHeaders=host&X-Amz-Signature=ee157ccf218ef1b841f2b549afb23b5de68c3d239690538ebf5a43418cb48d94",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1466/original/Image_from_Gboard_clipboard.jpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZC22Z4TRTU%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122257Z&X-Amz-Expires=18244&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFMaCXVzLWVhc3QtMSJGMEQCIAvef8thu3D0%2Bq%2B8kc3AaQKF6HASw8w1yNSfiU8zpiURAiBJ6gw%2B4d5GpYwaxbGRLGP2dLjAEkZ1tZy40iYnH%2F9xiCqzBQgcEAAaDDU1OTYwMzcwMzM2NSIM5%2FiGHG1zJeqwlDunKpAFF9ypPcY7nXi5TrdrrkhNRnVc1l92IG1Uke41ktQcr6%2BnXpVLsHyL1Gs24hi4Qokf8WNIDEnsm7Msy7NoS7O%2FT0kDr7jZEHmFNWn27nJpF02fDhiqRJCS8YIiO5RnGXkUqUNHUMAp3cdjGD8pXjF92flLHiUU0lpjGiPtXXgwMwHhreX8jE8WFMMFWo%2F4ayB5CBtdnaVD80dHlMbRyOQp7s4ZKCNWYtl627HeeVg1CuvRcNB6TwfGOYkwpIYP%2F1hIg8Ld%2BTjagMuxqO9PnhPuvZAaTa4gZCKCES0UkvnTBK0ToPVEE%2BkQOmKf9PL97K4qoefFzOiMcCR4QINy1SRB06rx9eLgDGMJGC2oPJ%2B6aqGf5zg%2B6nt%2BcbPLob68nIx0ipjpbjetnTQnFPhLbmm2MzQa8AzHAXEjcKxsgdtvreWz03qAU1OJeHuVSfJ7I8DDVRn50XsTy%2B0zzfhg13AW2SWF5MO2Q5DunEaAFFT5n2Nm1xktA0XR47c572vyjTFLzkwvIdb7isdlUh%2B8X0YSAHNBgiMago6yKH84b531gERFDSKinNC7CT%2B7OAQhhRmUZHPrgCP8QsHC5gM9dybF6nw9jGq7jfBOZpBlJ2qmSxRiZjrNMx7mifFw0AVs52sI%2Bo0zbEeo%2BMNHa0lN8zNCqQgVr1xQcxN2KFIVWUxBXO0AQYcxajgx1mcqdqXwC3NpE1yykBDcdmU%2BU4QH1yoDVxiGx%2FgJgwTPlPUKuD4JL8oLwIthfULQo%2BurlOD1jdiQ9J3OMGfxGHX2RpjfGO4Sul001Iwa5xOy3eMJmjsAJ5qALUKyBgGGye2UQy88VWNGHGAGXDunMA2vyMcxTeIPqYaCvpIKBPRrynZlNQ0nrP8wle%2FA0AY6sgEvaRyMXqGtZbcqKy2QkSbf7%2B7VreZr4hf09NuuyDjLMzR%2FQTYYScDzxqV4zEokOG2eegIYs6pogcPHxgRd1LPSMZlj236ZpSsv6d6l2M5WJ%2FHPySYOnpJW%2BUEIlkc6Awav%2FYf%2BvnINFRhjn513m%2B4cp1SB8LPUUbE4aAXqqpT00Lcd7W3D2oVkVc5ZZyn%2F99EQWoSON9B5Vhv%2BvcehG5k2M50WuJ4lmWTnzlIC2Gu0G9Cq&X-Amz-SignedHeaders=host&X-Amz-Signature=161fa6c5ca2aa1766e1397d008ef211f9e59d515c0408562a79c06b0c70fb24d"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "No",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": "Yes"
            }
        },
        {
            "id": 2232,
            "name": "Hanging Spigot (HD) - To suit LX Hard Ladder",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1392/thumb/shared_image__25__Background_Removed.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCQB5RV5UF%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122303Z&X-Amz-Expires=12506&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFIaCXVzLWVhc3QtMSJGMEQCIFpm%2FdzQc5ajAFMefFHHmLWWFpTP8P%2BpsHctbDJiKPDpAiA0X5VckQQ%2B50E%2BSQ%2BI%2FKcVOJw94gqxHj6r40oDs4inCCqzBQgbEAAaDDU1OTYwMzcwMzM2NSIMjHN4V2i6M2H6MN3kKpAFBMHP%2Fs2Zs%2FsZ9oX8G4RMYTpkAJRzTPLL30Was5MOJ9gcip4HXHdJMLZ%2F4H9XoGYTgL%2BNWE2ChRqzWB3SLT2%2B7dz%2FvFwavIa8Anu5ihzcV5NflXQCl%2BxXSugqBbBUC2ElwVMb7Vtpfs7frtxS70Dz%2FElkBbLVRzxQNub6R66J6o7WzIfnEfutCS6Dj7%2B%2FlNaHuv0uc3EZShsVQc5bD%2F2eRz4NBkyQLl90f5X1qDsdKuoyVLFz7n9KVNsWkgMooilolBTj0C95CkOGNqLUe3uXt%2BY1mm0kJXirp4GKokBb37yZDxjd6tUGDfSGN0oQp1p4lBTuOYWuiWZFuZOVseaxCE9ntYeB5As8kJemqe907rR0UcL8iG3%2F0nC3akdQ2z2OIzdQCrs2imgzzAxAdqIRCdHas7iQ3IR9QtAMGQWu0Hf8zHmmjJB4%2FbEBCxrUM9tQ5FvH4BwvOV99NfuVloUCQtnzVkymWG9eaXuAAGSjiRxj75YZPELzOptB9GuNgVOVzjPP2Jolrh2yec0h2Drmm854dCY%2BzCzhNhtqT%2FtFnpoTaLC0wlF7eeKb9EbKCL4j9bqLAAEJRf%2BXqvHtd3VISLldNRIE4pzpdIuqSyZxOWGlUW1zEEXIazSQJaG%2BGZtqVTpbZnZTcMLn%2FZlyxFacVmUTPDdtuHYJd7Vnf1w5ovkwKEMfKoc4KB5gq0cPQi%2BhUn01zmV1aY8BofituissM0B%2FU%2BEfmxop0%2FkanxXxIWFH13tvxUZUSBSXkOvfilBgdPtTQs7jPpOjN116FpQEvhM07BH4eZ7qCvwzv5gmVJBS6s6nEtykffjrUc1fRMH4jRXT4M%2FPwuEeTdiWFD9tDECmwUTqAOqJ8gVs6k482y4wm8TA0AY6sgE7LsUsBXqwxxAJmsHXkhPgAWiHQ5hrUOicr%2FWLfq%2FWsQf1agpNRuPAP6dQG%2BQ4rjvk1yHnoi3Xcinccu8TyEgM8lypqQBlZ%2FvoreLU3XSweo7W0iqCn6Hq2KmcGokiB6WbEYaVYWPK8QorxYR7ZGbTV%2F0fLnPa2oqKpUXZAec2YikfOC75GfZQZVCra2LipHyAJPJL2Yc6m%2FZpoaO7AAOdb1WAcTYN2OdJpryqnPOU06Lv&X-Amz-SignedHeaders=host&X-Amz-Signature=ba4414dca4588980ae8e94254d272f66617eb2060d82653eac2c73e172e965db",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1392/original/shared_image__25__Background_Removed.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCQB5RV5UF%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122303Z&X-Amz-Expires=12506&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFIaCXVzLWVhc3QtMSJGMEQCIFpm%2FdzQc5ajAFMefFHHmLWWFpTP8P%2BpsHctbDJiKPDpAiA0X5VckQQ%2B50E%2BSQ%2BI%2FKcVOJw94gqxHj6r40oDs4inCCqzBQgbEAAaDDU1OTYwMzcwMzM2NSIMjHN4V2i6M2H6MN3kKpAFBMHP%2Fs2Zs%2FsZ9oX8G4RMYTpkAJRzTPLL30Was5MOJ9gcip4HXHdJMLZ%2F4H9XoGYTgL%2BNWE2ChRqzWB3SLT2%2B7dz%2FvFwavIa8Anu5ihzcV5NflXQCl%2BxXSugqBbBUC2ElwVMb7Vtpfs7frtxS70Dz%2FElkBbLVRzxQNub6R66J6o7WzIfnEfutCS6Dj7%2B%2FlNaHuv0uc3EZShsVQc5bD%2F2eRz4NBkyQLl90f5X1qDsdKuoyVLFz7n9KVNsWkgMooilolBTj0C95CkOGNqLUe3uXt%2BY1mm0kJXirp4GKokBb37yZDxjd6tUGDfSGN0oQp1p4lBTuOYWuiWZFuZOVseaxCE9ntYeB5As8kJemqe907rR0UcL8iG3%2F0nC3akdQ2z2OIzdQCrs2imgzzAxAdqIRCdHas7iQ3IR9QtAMGQWu0Hf8zHmmjJB4%2FbEBCxrUM9tQ5FvH4BwvOV99NfuVloUCQtnzVkymWG9eaXuAAGSjiRxj75YZPELzOptB9GuNgVOVzjPP2Jolrh2yec0h2Drmm854dCY%2BzCzhNhtqT%2FtFnpoTaLC0wlF7eeKb9EbKCL4j9bqLAAEJRf%2BXqvHtd3VISLldNRIE4pzpdIuqSyZxOWGlUW1zEEXIazSQJaG%2BGZtqVTpbZnZTcMLn%2FZlyxFacVmUTPDdtuHYJd7Vnf1w5ovkwKEMfKoc4KB5gq0cPQi%2BhUn01zmV1aY8BofituissM0B%2FU%2BEfmxop0%2FkanxXxIWFH13tvxUZUSBSXkOvfilBgdPtTQs7jPpOjN116FpQEvhM07BH4eZ7qCvwzv5gmVJBS6s6nEtykffjrUc1fRMH4jRXT4M%2FPwuEeTdiWFD9tDECmwUTqAOqJ8gVs6k482y4wm8TA0AY6sgE7LsUsBXqwxxAJmsHXkhPgAWiHQ5hrUOicr%2FWLfq%2FWsQf1agpNRuPAP6dQG%2BQ4rjvk1yHnoi3Xcinccu8TyEgM8lypqQBlZ%2FvoreLU3XSweo7W0iqCn6Hq2KmcGokiB6WbEYaVYWPK8QorxYR7ZGbTV%2F0fLnPa2oqKpUXZAec2YikfOC75GfZQZVCra2LipHyAJPJL2Yc6m%2FZpoaO7AAOdb1WAcTYN2OdJpryqnPOU06Lv&X-Amz-SignedHeaders=host&X-Amz-Signature=cea00a0bf6f5474563d34bc453a5424e8637eba16b16a0732469ab047a3cd7bc"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "No",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": "Yes"
            }
        },
        {
            "id": 1925,
            "name": "Patch Cable for Touring Rack - Female (GST18) to 240v Male",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1424/thumb/shared_image__13_.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZC2HEKDCJE%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122308Z&X-Amz-Expires=4879&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFAaCXVzLWVhc3QtMSJHMEUCIA1KxQn1bAVhksHahsQInj6qqBp6VF%2FklQc4amNBgo%2FDAiEAyUx%2BiRA3LdiyhvoyPm3tG4W%2BnEk3REKheXqIAw2Y%2F4sqtAUIGBAAGgw1NTk2MDM3MDMzNjUiDJ5z1I3k0v94cCWoHSqRBUMwE%2FubHqHhcWxk6K%2BPiYR%2FX6kCOoIxRe7IEQZoAWfGyX5NstnOo8Ovsvb18687V%2FivQT1sUidKVVrv6cyFjKC2lU1sxD0PJEfppU5SIbxFBBKp3MW2AfJX4dmLHWLTVuDwp%2BzVqAXnZT5dDD8atlXme7AX%2Bt84HQIA3da4yq0uAI18ZXWe%2B0p9Z7BYq%2F2BHFJvWYnZfRV6FArVEow9qglGvUsxy%2BEbyCbZJlGFNvXoagM%2BE%2BZOwYn5hCZT5G708ezb9Gvc3TbU9N9%2F5imc9Ald7Cn8hxSnXzihvvIXn4tGJUvriKfd7WQc6xYGGqXkl3cNEmFkdPjqqRieVtW%2BnJFWsR09k5DK%2BBs3bp9iYueF1ieJ8px0ueCFJ%2FUXpWzG5r0NwTqjTN0uENMacAJR3zyXuy6tsHqDWbhmy0%2BQHRijdjbubq17ZVKcJ%2FhEHR8kr6dUhKQGUPMRwy7wb%2FxUZfF5mnzvCkeRzVH6CpyOFABRAkTIpFHqpJg9JX1wsOsLfT%2B%2B44%2BEKpaAXrmK54oNGCKkRgAyLTY%2BHUMJ6VTm8PA9yfVlADEgXyLauI%2FGqt556gQwCA%2B8vyxzDEXoMkfkoyUT2QumipHPnQXSgfz7%2F6FO6Y%2BcYYQFy%2BbzBgmRdg%2Bf39NaQUGWrECduKvhtIUwUDnZWKdEUDC2mqmOZDeFzBX9YAJyV5WtGHQpVJUEwlcjGrYcKka7kxab9bDfPWYb1qVKSKhb2a0dv4vVlCBSkAs36k2CLxrTluolQjTTTlLLm4ehxkUV2ETPfUuMjqfD0IHEpIcKb3APpcgLsh2sGIP4QrBYujVp08VgAjU274yHK%2BYVz%2BkqLvCpxFn48QOS8RoXMCQK3Z62Fozn6Huk8XHUUjC%2Bh8DQBjqxAUYFqQ5GPloWeow6qM5qPX7uafFMCNVktARrMBQWTpiPpcbjLCh6On8SQ6brOQszE5UI1iGxJH%2F6S4LfkFClUG68gzRT7c0hgSju6zapDtjBtIXzJrskZoP5uSDnvj3xan7uOZr3ZjIqEiaD%2FmofS3Aa7j73fr7M5OhGdMYM24wkQfyAlTZrfHh3Rzp%2BSpcB%2F2LpYCI0xYcgmeG9MVrwtdt7BRRsMgzVG281sqi1gc4T8g%3D%3D&X-Amz-SignedHeaders=host&X-Amz-Signature=e79dd99c01ee45cad3d75097fbebe3fed4be0c2e3a802f81968296844a4bde28",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1424/original/shared_image__13_.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZC2HEKDCJE%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122308Z&X-Amz-Expires=4879&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFAaCXVzLWVhc3QtMSJHMEUCIA1KxQn1bAVhksHahsQInj6qqBp6VF%2FklQc4amNBgo%2FDAiEAyUx%2BiRA3LdiyhvoyPm3tG4W%2BnEk3REKheXqIAw2Y%2F4sqtAUIGBAAGgw1NTk2MDM3MDMzNjUiDJ5z1I3k0v94cCWoHSqRBUMwE%2FubHqHhcWxk6K%2BPiYR%2FX6kCOoIxRe7IEQZoAWfGyX5NstnOo8Ovsvb18687V%2FivQT1sUidKVVrv6cyFjKC2lU1sxD0PJEfppU5SIbxFBBKp3MW2AfJX4dmLHWLTVuDwp%2BzVqAXnZT5dDD8atlXme7AX%2Bt84HQIA3da4yq0uAI18ZXWe%2B0p9Z7BYq%2F2BHFJvWYnZfRV6FArVEow9qglGvUsxy%2BEbyCbZJlGFNvXoagM%2BE%2BZOwYn5hCZT5G708ezb9Gvc3TbU9N9%2F5imc9Ald7Cn8hxSnXzihvvIXn4tGJUvriKfd7WQc6xYGGqXkl3cNEmFkdPjqqRieVtW%2BnJFWsR09k5DK%2BBs3bp9iYueF1ieJ8px0ueCFJ%2FUXpWzG5r0NwTqjTN0uENMacAJR3zyXuy6tsHqDWbhmy0%2BQHRijdjbubq17ZVKcJ%2FhEHR8kr6dUhKQGUPMRwy7wb%2FxUZfF5mnzvCkeRzVH6CpyOFABRAkTIpFHqpJg9JX1wsOsLfT%2B%2B44%2BEKpaAXrmK54oNGCKkRgAyLTY%2BHUMJ6VTm8PA9yfVlADEgXyLauI%2FGqt556gQwCA%2B8vyxzDEXoMkfkoyUT2QumipHPnQXSgfz7%2F6FO6Y%2BcYYQFy%2BbzBgmRdg%2Bf39NaQUGWrECduKvhtIUwUDnZWKdEUDC2mqmOZDeFzBX9YAJyV5WtGHQpVJUEwlcjGrYcKka7kxab9bDfPWYb1qVKSKhb2a0dv4vVlCBSkAs36k2CLxrTluolQjTTTlLLm4ehxkUV2ETPfUuMjqfD0IHEpIcKb3APpcgLsh2sGIP4QrBYujVp08VgAjU274yHK%2BYVz%2BkqLvCpxFn48QOS8RoXMCQK3Z62Fozn6Huk8XHUUjC%2Bh8DQBjqxAUYFqQ5GPloWeow6qM5qPX7uafFMCNVktARrMBQWTpiPpcbjLCh6On8SQ6brOQszE5UI1iGxJH%2F6S4LfkFClUG68gzRT7c0hgSju6zapDtjBtIXzJrskZoP5uSDnvj3xan7uOZr3ZjIqEiaD%2FmofS3Aa7j73fr7M5OhGdMYM24wkQfyAlTZrfHh3Rzp%2BSpcB%2F2LpYCI0xYcgmeG9MVrwtdt7BRRsMgzVG281sqi1gc4T8g%3D%3D&X-Amz-SignedHeaders=host&X-Amz-Signature=01ba844994f57df2a7b3f8e66240a7dfb8795eccb92f4e3a32243eeb2b6b7e02"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "No",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": "Yes"
            }
        },
        {
            "id": 920,
            "name": "Herc Ring",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1380/thumb/920.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCQB5RV5UF%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122314Z&X-Amz-Expires=12495&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFIaCXVzLWVhc3QtMSJGMEQCIFpm%2FdzQc5ajAFMefFHHmLWWFpTP8P%2BpsHctbDJiKPDpAiA0X5VckQQ%2B50E%2BSQ%2BI%2FKcVOJw94gqxHj6r40oDs4inCCqzBQgbEAAaDDU1OTYwMzcwMzM2NSIMjHN4V2i6M2H6MN3kKpAFBMHP%2Fs2Zs%2FsZ9oX8G4RMYTpkAJRzTPLL30Was5MOJ9gcip4HXHdJMLZ%2F4H9XoGYTgL%2BNWE2ChRqzWB3SLT2%2B7dz%2FvFwavIa8Anu5ihzcV5NflXQCl%2BxXSugqBbBUC2ElwVMb7Vtpfs7frtxS70Dz%2FElkBbLVRzxQNub6R66J6o7WzIfnEfutCS6Dj7%2B%2FlNaHuv0uc3EZShsVQc5bD%2F2eRz4NBkyQLl90f5X1qDsdKuoyVLFz7n9KVNsWkgMooilolBTj0C95CkOGNqLUe3uXt%2BY1mm0kJXirp4GKokBb37yZDxjd6tUGDfSGN0oQp1p4lBTuOYWuiWZFuZOVseaxCE9ntYeB5As8kJemqe907rR0UcL8iG3%2F0nC3akdQ2z2OIzdQCrs2imgzzAxAdqIRCdHas7iQ3IR9QtAMGQWu0Hf8zHmmjJB4%2FbEBCxrUM9tQ5FvH4BwvOV99NfuVloUCQtnzVkymWG9eaXuAAGSjiRxj75YZPELzOptB9GuNgVOVzjPP2Jolrh2yec0h2Drmm854dCY%2BzCzhNhtqT%2FtFnpoTaLC0wlF7eeKb9EbKCL4j9bqLAAEJRf%2BXqvHtd3VISLldNRIE4pzpdIuqSyZxOWGlUW1zEEXIazSQJaG%2BGZtqVTpbZnZTcMLn%2FZlyxFacVmUTPDdtuHYJd7Vnf1w5ovkwKEMfKoc4KB5gq0cPQi%2BhUn01zmV1aY8BofituissM0B%2FU%2BEfmxop0%2FkanxXxIWFH13tvxUZUSBSXkOvfilBgdPtTQs7jPpOjN116FpQEvhM07BH4eZ7qCvwzv5gmVJBS6s6nEtykffjrUc1fRMH4jRXT4M%2FPwuEeTdiWFD9tDECmwUTqAOqJ8gVs6k482y4wm8TA0AY6sgE7LsUsBXqwxxAJmsHXkhPgAWiHQ5hrUOicr%2FWLfq%2FWsQf1agpNRuPAP6dQG%2BQ4rjvk1yHnoi3Xcinccu8TyEgM8lypqQBlZ%2FvoreLU3XSweo7W0iqCn6Hq2KmcGokiB6WbEYaVYWPK8QorxYR7ZGbTV%2F0fLnPa2oqKpUXZAec2YikfOC75GfZQZVCra2LipHyAJPJL2Yc6m%2FZpoaO7AAOdb1WAcTYN2OdJpryqnPOU06Lv&X-Amz-SignedHeaders=host&X-Amz-Signature=4a07b44c65b9d51f4d82e4cb9ed7e348d197fe28724e27ee23ad96a24b236bf2",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1380/original/920.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCQB5RV5UF%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122314Z&X-Amz-Expires=12495&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFIaCXVzLWVhc3QtMSJGMEQCIFpm%2FdzQc5ajAFMefFHHmLWWFpTP8P%2BpsHctbDJiKPDpAiA0X5VckQQ%2B50E%2BSQ%2BI%2FKcVOJw94gqxHj6r40oDs4inCCqzBQgbEAAaDDU1OTYwMzcwMzM2NSIMjHN4V2i6M2H6MN3kKpAFBMHP%2Fs2Zs%2FsZ9oX8G4RMYTpkAJRzTPLL30Was5MOJ9gcip4HXHdJMLZ%2F4H9XoGYTgL%2BNWE2ChRqzWB3SLT2%2B7dz%2FvFwavIa8Anu5ihzcV5NflXQCl%2BxXSugqBbBUC2ElwVMb7Vtpfs7frtxS70Dz%2FElkBbLVRzxQNub6R66J6o7WzIfnEfutCS6Dj7%2B%2FlNaHuv0uc3EZShsVQc5bD%2F2eRz4NBkyQLl90f5X1qDsdKuoyVLFz7n9KVNsWkgMooilolBTj0C95CkOGNqLUe3uXt%2BY1mm0kJXirp4GKokBb37yZDxjd6tUGDfSGN0oQp1p4lBTuOYWuiWZFuZOVseaxCE9ntYeB5As8kJemqe907rR0UcL8iG3%2F0nC3akdQ2z2OIzdQCrs2imgzzAxAdqIRCdHas7iQ3IR9QtAMGQWu0Hf8zHmmjJB4%2FbEBCxrUM9tQ5FvH4BwvOV99NfuVloUCQtnzVkymWG9eaXuAAGSjiRxj75YZPELzOptB9GuNgVOVzjPP2Jolrh2yec0h2Drmm854dCY%2BzCzhNhtqT%2FtFnpoTaLC0wlF7eeKb9EbKCL4j9bqLAAEJRf%2BXqvHtd3VISLldNRIE4pzpdIuqSyZxOWGlUW1zEEXIazSQJaG%2BGZtqVTpbZnZTcMLn%2FZlyxFacVmUTPDdtuHYJd7Vnf1w5ovkwKEMfKoc4KB5gq0cPQi%2BhUn01zmV1aY8BofituissM0B%2FU%2BEfmxop0%2FkanxXxIWFH13tvxUZUSBSXkOvfilBgdPtTQs7jPpOjN116FpQEvhM07BH4eZ7qCvwzv5gmVJBS6s6nEtykffjrUc1fRMH4jRXT4M%2FPwuEeTdiWFD9tDECmwUTqAOqJ8gVs6k482y4wm8TA0AY6sgE7LsUsBXqwxxAJmsHXkhPgAWiHQ5hrUOicr%2FWLfq%2FWsQf1agpNRuPAP6dQG%2BQ4rjvk1yHnoi3Xcinccu8TyEgM8lypqQBlZ%2FvoreLU3XSweo7W0iqCn6Hq2KmcGokiB6WbEYaVYWPK8QorxYR7ZGbTV%2F0fLnPa2oqKpUXZAec2YikfOC75GfZQZVCra2LipHyAJPJL2Yc6m%2FZpoaO7AAOdb1WAcTYN2OdJpryqnPOU06Lv&X-Amz-SignedHeaders=host&X-Amz-Signature=2a71e39e901b3fe7e0fdd06f848d4265f10520a1ef950afd36e4ba93d59968ba"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "No",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": "Yes"
            }
        },
        {
            "id": 1911,
            "name": "Ratchet Strap - MPH (Black)",
            "icon": {
                "thumb_url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1113/thumb/mph_strap_Black.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCVFYTE57K%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122320Z&X-Amz-Expires=19486&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFQaCXVzLWVhc3QtMSJIMEYCIQD3KYvv0uPjc%2FdDXQl2gnHFlZ5Ko5L5P9m0eLN%2BDlmJRQIhAK0sr6OcV%2BcP69OpyOQbUOSJ%2FeEVbL7wLzeblTUmWX7OKrQFCB0QABoMNTU5NjAzNzAzMzY1IgxS4KYH38sEy%2F4u%2BLMqkQUrP%2B6Doz%2BfB4lGmGwflNDIIxZxADuv8WzcjM73Wm5llcZVZ46dvehVetG4ojOZHwz2vrQxdLS4lUWW7VYCeNN%2F7p6JepMlm30%2Ft%2FV83%2FNlpDIONJlo1An5MhLrzBWXHgnfR6TLZt3jqirGSlbmmvytqIzG%2FXn7yLHVqKj2eSpqPmHJZBShsu9aIHPAetoquH1tpC9iPk3HnWpX%2F6RcmlIZdGmxcjvAXkQOVExbIkb8MzimXe%2FHAglc37mtOAPRJAyJEHFnFqAeoS31y%2FFENmlrRGUP6nyVKMS6CzM38ehKS1SR8J%2BYUSl3vY4YVlmUSITpvXyeCOGDfkCQfdQo3LUy%2FyHj58KuRYO0ZL2Z4zfdMio3Ldh5vvVogel8W%2BiQ6jMEkKX%2BRh7SLrhY8sq3JoMom2xtPzOCke2B9pbBORw3eyL57KLxlV7Lg%2FbUKXFIkesYWzOP6tiO1muwpAG4t818gNz2k%2FGOs8N9zGqZvHntWM0ETq6G7ITo8J%2BHDHF2L9Wf8%2BzQNnlxEfrQZw%2FKmelDDgs9QFUMg5LmLOZiBJhMth%2FEAoaZIvdECJ3UvaktNE1TZo49JtPzSgsynHWEjF2Y7cf76tdyARXJwrs6RL%2BUGUfl7nEt9bibshQMs1NnT%2FcIr6qECdnCPcpcHFefPan56fma9xnMqqIu2nmJUGCn0AEInrFNAS9mghOFxfjQ0BE4OJdPcaeGDS6tvRH0n5R1366oqJQthDN%2FC35IY6h0RVU67wWr%2FkTxquk%2B73PQxfR1AM8KXEKi5e%2FpVkdY4gOlbDeB5608Y4pIfrLF%2BokZs7dpmzR7MswjYjykQjC8P4ExrVi3jP0C90mBGt3ZzEW0n3LzuDI%2BG4NAan2sMfsmK1Awiv%2FA0AY6sAGlWjnYJNhePhZ%2BI4A4zkgkkKcTs%2FjFvrL%2F5kJlfaG6QpPuKLSCEGKKS6G71GZo%2B9NOhxHA3biiD7k2oaHl8w1RbIWmQ%2Bouugtbp6%2FqypQisQO5flzUwkOH9TrfmvjUH5uxX27hJ20vwwBV1sGDNzIg5dmTIsBrTlfL%2BB0Dr1rxPWM3jRddgES9FK8MYwjePL1ybgKN9Nixal7VRAzhMhnJvaJbUxQ1tAi%2BUZFO0AOTjQ%3D%3D&X-Amz-SignedHeaders=host&X-Amz-Signature=15005a6debbf3e2c6be50008861878a0e8e6c1a574a630cd85b00cedf5249f32",
                "url": "https://current-rms.s3.amazonaws.com/0647e470-3ff3-0134-e076-12f3e469bf2a/icons/1113/original/mph_strap_Black.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAYESX23ZCVFYTE57K%2F20260522%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260522T122320Z&X-Amz-Expires=19486&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFQaCXVzLWVhc3QtMSJIMEYCIQD3KYvv0uPjc%2FdDXQl2gnHFlZ5Ko5L5P9m0eLN%2BDlmJRQIhAK0sr6OcV%2BcP69OpyOQbUOSJ%2FeEVbL7wLzeblTUmWX7OKrQFCB0QABoMNTU5NjAzNzAzMzY1IgxS4KYH38sEy%2F4u%2BLMqkQUrP%2B6Doz%2BfB4lGmGwflNDIIxZxADuv8WzcjM73Wm5llcZVZ46dvehVetG4ojOZHwz2vrQxdLS4lUWW7VYCeNN%2F7p6JepMlm30%2Ft%2FV83%2FNlpDIONJlo1An5MhLrzBWXHgnfR6TLZt3jqirGSlbmmvytqIzG%2FXn7yLHVqKj2eSpqPmHJZBShsu9aIHPAetoquH1tpC9iPk3HnWpX%2F6RcmlIZdGmxcjvAXkQOVExbIkb8MzimXe%2FHAglc37mtOAPRJAyJEHFnFqAeoS31y%2FFENmlrRGUP6nyVKMS6CzM38ehKS1SR8J%2BYUSl3vY4YVlmUSITpvXyeCOGDfkCQfdQo3LUy%2FyHj58KuRYO0ZL2Z4zfdMio3Ldh5vvVogel8W%2BiQ6jMEkKX%2BRh7SLrhY8sq3JoMom2xtPzOCke2B9pbBORw3eyL57KLxlV7Lg%2FbUKXFIkesYWzOP6tiO1muwpAG4t818gNz2k%2FGOs8N9zGqZvHntWM0ETq6G7ITo8J%2BHDHF2L9Wf8%2BzQNnlxEfrQZw%2FKmelDDgs9QFUMg5LmLOZiBJhMth%2FEAoaZIvdECJ3UvaktNE1TZo49JtPzSgsynHWEjF2Y7cf76tdyARXJwrs6RL%2BUGUfl7nEt9bibshQMs1NnT%2FcIr6qECdnCPcpcHFefPan56fma9xnMqqIu2nmJUGCn0AEInrFNAS9mghOFxfjQ0BE4OJdPcaeGDS6tvRH0n5R1366oqJQthDN%2FC35IY6h0RVU67wWr%2FkTxquk%2B73PQxfR1AM8KXEKi5e%2FpVkdY4gOlbDeB5608Y4pIfrLF%2BokZs7dpmzR7MswjYjykQjC8P4ExrVi3jP0C90mBGt3ZzEW0n3LzuDI%2BG4NAan2sMfsmK1Awiv%2FA0AY6sAGlWjnYJNhePhZ%2BI4A4zkgkkKcTs%2FjFvrL%2F5kJlfaG6QpPuKLSCEGKKS6G71GZo%2B9NOhxHA3biiD7k2oaHl8w1RbIWmQ%2Bouugtbp6%2FqypQisQO5flzUwkOH9TrfmvjUH5uxX27hJ20vwwBV1sGDNzIg5dmTIsBrTlfL%2BB0Dr1rxPWM3jRddgES9FK8MYwjePL1ybgKN9Nixal7VRAzhMhnJvaJbUxQ1tAi%2BUZFO0AOTjQ%3D%3D&X-Amz-SignedHeaders=host&X-Amz-Signature=25ea8e8dd12ed5899246f5864b9e46c1c8ea1fc8a79d256990e3c000bdc01bc4"
            },
            "custom_fields": {
                "colour_coded_storage": "",
                "nally_bin_storage": "Yes",
                "nally_bin_storage_stored_at_height": "",
                "tub_storage": ""
            }
        }
    ]);
    const [processing, setProcessing] = useState(false);

    const handleProductSearchSelectChange = (option: ProductOption | null) => {
        if (option) {
            setProducts(prevProducts => {
                if (prevProducts.some(product => product.id === option.product.id)) {
                    return prevProducts;
                }

                return [...prevProducts, option.product];
            });
        }
    };

    const handleRemoveProduct = (productId: number) => {
        setProducts(prevProducts => prevProducts.filter(product => product.id !== productId));
    };

    const handleGenerateLabels = () => {
        setProcessing(true);
        router.post(ProductsLabelsGenerateController().url, { products }, {
            onError() {
                setProcessing(false);
            },
        });
    };

    return (
        <>
            <Head title={title} />
            <div className="md:grid md:gap-4 md:grid-cols-3 md:items-stretch xl:grid-cols-4">
                <div className="space-y-4 md:col-span-2 xl:col-span-3 md:flex md:flex-col md:min-h-0">
                    <ProductSearchSelect
                        name="product"
                        placeholder="Search for products..."
                        clearOnSelect
                        params={{
                            'per_page': 20,
                            'q[name_cont]': '?',
                        }}
                        onChange={handleProductSearchSelectChange}
                    />
                    {errors.products && (
                        <div
                            role="alert"
                            className="alert alert-error alert-soft block"
                            dangerouslySetInnerHTML={{ __html: errors.products }}
                        ></div>
                    )}
                    {products.length > 0 ? (
                        <div className="flex-1 min-h-0 overflow-y-auto max-h-[calc(100dvh-14rem)] rounded-b-lg md:max-h-[calc(100dvh-10.5rem)]">
                            <ProductList
                                products={products}
                                onClear={() => setProducts([])}
                                onRemove={handleRemoveProduct}
                            />
                        </div>
                    ) : (
                        <div className="alert alert-info alert-soft">{'No products have been selected. Search for and select products to generate labels.'}</div>
                    )}
                </div>
                <div className="place-self-start">
                    <ProductGenerateLabels
                        processing={processing}
                        disabled={products.length === 0}
                        onGenerate={handleGenerateLabels}
                    />
                </div>
            </div>
            <ProductFloatingGenerateLabels
                processing={processing}
                disabled={products.length === 0}
                onGenerate={handleGenerateLabels}
            />
        </>
    );
}