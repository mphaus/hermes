import "./bootstrap";
import.meta.glob([
    './../images/**',
]);

import { Alpine, Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";
import ActionStreamFilters from "./components/ActionStreamFilters";
import ActionStreamItem from "./components/ActionStreamItem";
import Alert from "./components/Alert";
import CreateDiscussionsObject from "./components/CreateDiscussionsObject";
import CreateDiscussionsOwner from "./components/CreateDiscussionsOwner";
import Qet from "./components/Qet";
import QetItem from "./components/QetItem";
import EquipmentImportForm from "./components/EquipmentImportForm";
import SelectFaultRootCause from "./components/SelectFaultRootCause";
import SelectOpportunity from "./components/SelectOpportunity";
import SelectProduct from "./components/SelectProduct";
import SideMenu from "./components/SideMenu";
import UploadLog from "./components/UploadLog";
import SelectProject from "./components/SelectProject";
import DiscussionSelectOwner from "./components/DiscussionSelectOwner";
import SelectOwner from "./components/SelectOwner";

Alpine.data('ActionStreamFilters', ActionStreamFilters);
Alpine.data('ActionStreamItem', ActionStreamItem);
Alpine.data('Alert', Alert);
Alpine.data('CreateDiscussionsObject', CreateDiscussionsObject);
Alpine.data('CreateDiscussionsOwner', CreateDiscussionsOwner);
Alpine.data('Qet', Qet);
Alpine.data('QetItem', QetItem);
Alpine.data('EquipmentImportForm', EquipmentImportForm);
Alpine.data('SelectFaultRootCause', SelectFaultRootCause);
Alpine.data('SelectOpportunity', SelectOpportunity);
Alpine.data('SelectProduct', SelectProduct);
Alpine.data('SideMenu', SideMenu);
Alpine.data('UploadLog', UploadLog);
Alpine.data('SelectProject', SelectProject);
Alpine.data('DiscussionSelectOwner', DiscussionSelectOwner);
Alpine.data('SelectOwner', SelectOwner);

Livewire.start();
