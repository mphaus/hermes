import "./bootstrap";
import.meta.glob( [
    './../images/**',
] );

import { Livewire, Alpine } from "./../../vendor/livewire/livewire/dist/livewire.esm";
import Alert from "./components/Alert";
import ActionStreamFilters from "./components/ActionStreamFilters";
import ActionStreamItem from "./components/ActionStreamItem";
import CreateDiscussionsObject from "./components/CreateDiscussionsObject";
import CreateDiscussionsOwner from "./components/CreateDiscussionsOwner";
import ItemsCreateForm from "./components/ItemsCreateForm";
import Qet from "./components/Qet";
import QetItem from "./components/QetItem";
import UploadLog from "./components/UploadLog";
import UserForm from "./components/UserForm";
import UserDeleteButton from "./components/UserDeleteButton";
import ResetPasswordForm from "./components/ResetPasswordForm";
import SideMenu from "./components/SideMenu";
import QuarantineIntakeForm from "./components/QuarantineIntakeForm";
import SelectProduct from "./components/SelectProduct";
import SelectObject from "./components/SelectObject";
import SelectTechnicalSupervisor from "./components/SelectTechnicalSupervisor";
import SelectFaultRootCause from "./components/SelectFaultRootCause";
import QuarantineStatsFilter from "./components/QuarantineStatsFilter";
import QiInputStartsAt from "./components/QiInputStartsAt";
import QiSelectOpportunity from "./components/QiSelectOpportunity";
import QiSelectPrimaryFaultClassification from "./components/QiSelectPrimaryFaultClassification";

Alpine.data( 'Alert', Alert );
Alpine.data( 'ActionStreamFilters', ActionStreamFilters );
Alpine.data( 'ActionStreamItem', ActionStreamItem );
Alpine.data( 'CreateDiscussionsObject', CreateDiscussionsObject );
Alpine.data( 'CreateDiscussionsOwner', CreateDiscussionsOwner );
Alpine.data( 'ItemsCreateForm', ItemsCreateForm );
Alpine.data( 'Qet', Qet );
Alpine.data( 'QetItem', QetItem );
Alpine.data( 'UploadLog', UploadLog );
Alpine.data( 'UserForm', UserForm );
Alpine.data( 'UserDeleteButton', UserDeleteButton );
Alpine.data( 'ResetPasswordForm', ResetPasswordForm );
Alpine.data( 'SideMenu', SideMenu );
Alpine.data( 'QuarantineIntakeForm', QuarantineIntakeForm );
Alpine.data( 'SelectProduct', SelectProduct );
Alpine.data( 'SelectObject', SelectObject );
Alpine.data( 'SelectTechnicalSupervisor', SelectTechnicalSupervisor );
Alpine.data( 'SelectFaultRootCause', SelectFaultRootCause );
Alpine.data( 'QuarantineStatsFilter', QuarantineStatsFilter );
Alpine.data( 'QiInputStartsAt', QiInputStartsAt );
Alpine.data( 'QiSelectOpportunity', QiSelectOpportunity );
Alpine.data( 'QiSelectPrimaryFaultClassification', QiSelectPrimaryFaultClassification );

Livewire.start();
