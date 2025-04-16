import "./bootstrap";
import.meta.glob( [
    './../images/**',
] );

import { Alpine, Livewire } from "./../../vendor/livewire/livewire/dist/livewire.esm";
import ActionStreamFilters from "./components/ActionStreamFilters";
import ActionStreamItem from "./components/ActionStreamItem";
import Alert from "./components/Alert";
import CreateDiscussionsObject from "./components/CreateDiscussionsObject";
import CreateDiscussionsOwner from "./components/CreateDiscussionsOwner";
import Qet from "./components/Qet";
import QetItem from "./components/QetItem";
import QiInputStartsAt from "./components/QiInputStartsAt";
import QiSelectPrimaryFaultClassification from "./components/QiSelectPrimaryFaultClassification";
import QuarantineIntakeForm from "./components/QuarantineIntakeForm";
// import QuarantineStatsFilter from "./components/QuarantineStatsFilter";
import EquipmentImportForm from "./components/EquipmentImportForm";
import QiReportMistakeForm from "./components/QiReportMistakeForm";
import QiSelectDryHireOpportunity from "./components/QiSelectDryHireOpportunity";
import ResetPasswordForm from "./components/ResetPasswordForm";
import SelectFaultRootCause from "./components/SelectFaultRootCause";
import SelectObject from "./components/SelectObject";
import SelectOpportunity from "./components/SelectOpportunity";
import SelectProduct from "./components/SelectProduct";
import SelectTechnicalSupervisor from "./components/SelectTechnicalSupervisor";
import SideMenu from "./components/SideMenu";
import UploadLog from "./components/UploadLog";
import UserDeleteButton from "./components/UserDeleteButton";
import UserForm from "./components/UserForm";
import ProductionAdministratorForm from "./components/ProductionAdministratorForm";

Alpine.data( 'ActionStreamFilters', ActionStreamFilters );
Alpine.data( 'ActionStreamItem', ActionStreamItem );
Alpine.data( 'Alert', Alert );
Alpine.data( 'CreateDiscussionsObject', CreateDiscussionsObject );
Alpine.data( 'CreateDiscussionsOwner', CreateDiscussionsOwner );
Alpine.data( 'Qet', Qet );
Alpine.data( 'QetItem', QetItem );
Alpine.data( 'QiInputStartsAt', QiInputStartsAt );
Alpine.data( 'QiSelectPrimaryFaultClassification', QiSelectPrimaryFaultClassification );
Alpine.data( 'QuarantineIntakeForm', QuarantineIntakeForm );
// Alpine.data( 'QuarantineStatsFilter', QuarantineStatsFilter );
Alpine.data( 'EquipmentImportForm', EquipmentImportForm );
Alpine.data( 'QiSelectDryHireOpportunity', QiSelectDryHireOpportunity );
Alpine.data( 'ResetPasswordForm', ResetPasswordForm );
Alpine.data( 'SelectFaultRootCause', SelectFaultRootCause );
Alpine.data( 'SelectObject', SelectObject );
Alpine.data( 'SelectOpportunity', SelectOpportunity );
Alpine.data( 'SelectProduct', SelectProduct );
Alpine.data( 'SelectTechnicalSupervisor', SelectTechnicalSupervisor );
Alpine.data( 'SideMenu', SideMenu );
Alpine.data( 'UploadLog', UploadLog );
Alpine.data( 'UserDeleteButton', UserDeleteButton );
Alpine.data( 'UserForm', UserForm );
Alpine.data( 'QiReportMistakeForm', QiReportMistakeForm );
Alpine.data( 'ProductionAdministratorForm', ProductionAdministratorForm );

Livewire.start();
