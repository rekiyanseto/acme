<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'companies' => [
        'name' => 'Companies',
        'index_title' => 'Companies List',
        'new_title' => 'New Company',
        'create_title' => 'Create Company',
        'edit_title' => 'Edit Company',
        'show_title' => 'Show Company',
        'inputs' => [
            'company_code' => 'Company Code',
            'company_name' => 'Company Name',
            'company_site_plan' => 'Company Site Plan',
        ],
    ],

    'business_units' => [
        'name' => 'Business Units',
        'index_title' => 'BusinessUnits List',
        'new_title' => 'New Business unit',
        'create_title' => 'Create BusinessUnit',
        'edit_title' => 'Edit BusinessUnit',
        'show_title' => 'Show BusinessUnit',
        'inputs' => [
            'company_id' => 'Company',
            'business_unit_code' => 'Business Unit Code',
            'business_unit_name' => 'Business Unit Name',
            'business_unit_site_plan' => 'Business Unit Site Plan',
        ],
    ],

    'company_business_units' => [
        'name' => 'Company Business Units',
        'index_title' => 'BusinessUnits List',
        'new_title' => 'New Business unit',
        'create_title' => 'Create BusinessUnit',
        'edit_title' => 'Edit BusinessUnit',
        'show_title' => 'Show BusinessUnit',
        'inputs' => [
            'business_unit_code' => 'Business Unit Code',
            'business_unit_name' => 'Business Unit Name',
            'business_unit_site_plan' => 'Business Unit Site Plan',
        ],
    ],

    'functional_locations' => [
        'name' => 'Functional Locations',
        'index_title' => 'FunctionalLocations List',
        'new_title' => 'New Functional location',
        'create_title' => 'Create FunctionalLocation',
        'edit_title' => 'Edit FunctionalLocation',
        'show_title' => 'Show FunctionalLocation',
        'inputs' => [
            'business_unit_id' => 'Business Unit',
            'functional_location_code' => 'Functional Location Code',
            'functional_location_name' => 'Functional Location Name',
            'functional_location_site_plan' => 'Functional Location Site Plan',
        ],
    ],

    'business_unit_functional_locations' => [
        'name' => 'BusinessUnit Functional Locations',
        'index_title' => 'FunctionalLocations List',
        'new_title' => 'New Functional location',
        'create_title' => 'Create FunctionalLocation',
        'edit_title' => 'Edit FunctionalLocation',
        'show_title' => 'Show FunctionalLocation',
        'inputs' => [
            'functional_location_code' => 'Functional Location Code',
            'functional_location_name' => 'Functional Location Name',
            'functional_location_site_plan' => 'Functional Location Site Plan',
        ],
    ],

    'areas' => [
        'name' => 'Areas',
        'index_title' => 'Areas List',
        'new_title' => 'New Area',
        'create_title' => 'Create Area',
        'edit_title' => 'Edit Area',
        'show_title' => 'Show Area',
        'inputs' => [
            'functional_location_id' => 'Functional Location',
            'area_code' => 'Area Code',
            'area_name' => 'Area Name',
            'area_site_plan' => 'Area Site Plan',
        ],
    ],

    'functional_location_areas' => [
        'name' => 'FunctionalLocation Areas',
        'index_title' => 'Areas List',
        'new_title' => 'New Area',
        'create_title' => 'Create Area',
        'edit_title' => 'Edit Area',
        'show_title' => 'Show Area',
        'inputs' => [
            'area_code' => 'Area Code',
            'area_name' => 'Area Name',
            'area_site_plan' => 'Area Site Plan',
        ],
    ],

    'sub_areas' => [
        'name' => 'Sub Areas',
        'index_title' => 'SubAreas List',
        'new_title' => 'New Sub area',
        'create_title' => 'Create SubArea',
        'edit_title' => 'Edit SubArea',
        'show_title' => 'Show SubArea',
        'inputs' => [
            'area_id' => 'Area',
            'sub_area_code' => 'Sub Area Code',
            'sub_area_name' => 'Sub Area Name',
            'maintenance_by' => 'Maintenance By',
            'sub_area_description' => 'Sub Area Description',
            'sub_area_site_plan' => 'Sub Area Site Plan',
        ],
    ],

    'area_sub_areas' => [
        'name' => 'Area Sub Areas',
        'index_title' => 'SubAreas List',
        'new_title' => 'New Sub area',
        'create_title' => 'Create SubArea',
        'edit_title' => 'Edit SubArea',
        'show_title' => 'Show SubArea',
        'inputs' => [
            'sub_area_code' => 'Sub Area Code',
            'sub_area_name' => 'Sub Area Name',
            'maintenance_by' => 'Maintenance By',
            'sub_area_description' => 'Sub Area Description',
            'sub_area_site_plan' => 'Sub Area Site Plan',
        ],
    ],

    'equipments' => [
        'name' => 'Equipments',
        'index_title' => 'Equipments List',
        'new_title' => 'New Equipment',
        'create_title' => 'Create Equipment',
        'edit_title' => 'Edit Equipment',
        'show_title' => 'Show Equipment',
        'inputs' => [
            'sub_area_id' => 'Sub Area',
            'equipment_code' => 'Equipment Code',
            'equipment_name' => 'Equipment Name',
            'maintenance_by' => 'Maintenance By',
            'equipment_description' => 'Equipment Description',
        ],
    ],

    'categories' => [
        'name' => 'Categories',
        'index_title' => 'Categories List',
        'new_title' => 'New Category',
        'create_title' => 'Create Category',
        'edit_title' => 'Edit Category',
        'show_title' => 'Show Category',
        'inputs' => [
            'category_code' => 'Category Code',
            'category_name' => 'Category Name',
        ],
    ],

    'sub_categories' => [
        'name' => 'Sub Categories',
        'index_title' => 'SubCategories List',
        'new_title' => 'New Sub category',
        'create_title' => 'Create SubCategory',
        'edit_title' => 'Edit SubCategory',
        'show_title' => 'Show SubCategory',
        'inputs' => [
            'category_id' => 'Category',
            'category_code' => 'Category Code',
            'category_name' => 'Category Name',
        ],
    ],

    'category_sub_categories' => [
        'name' => 'Category Sub Categories',
        'index_title' => 'SubCategories List',
        'new_title' => 'New Sub category',
        'create_title' => 'Create SubCategory',
        'edit_title' => 'Edit SubCategory',
        'show_title' => 'Show SubCategory',
        'inputs' => [
            'category_code' => 'Category Code',
            'category_name' => 'Category Name',
        ],
    ],

    'survey_periods' => [
        'name' => 'Survey Periods',
        'index_title' => 'SurveyPeriods List',
        'new_title' => 'New Survey period',
        'create_title' => 'Create SurveyPeriod',
        'edit_title' => 'Edit SurveyPeriod',
        'show_title' => 'Show SurveyPeriod',
        'inputs' => [
            'periode_name' => 'Periode Name',
            'periode_description' => 'Periode Description',
            'periode_status' => 'Periode Status',
        ],
    ],

    'sub_area_surveys' => [
        'name' => 'SubArea Surveys',
        'index_title' => 'Surveys List',
        'new_title' => 'New Survey',
        'create_title' => 'Create Survey',
        'edit_title' => 'Edit Survey',
        'show_title' => 'Show Survey',
        'inputs' => [
            'survey_period_id' => 'Survey Period',
            'sub_category_id' => 'Sub Category',
        ],
    ],

    'equipment_surveys' => [
        'name' => 'Equipment Surveys',
        'index_title' => 'Surveys List',
        'new_title' => 'New Survey',
        'create_title' => 'Create Survey',
        'edit_title' => 'Edit Survey',
        'show_title' => 'Show Survey',
        'inputs' => [
            'survey_period_id' => 'Survey Period',
            'sub_category_id' => 'Sub Category',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'sub_area_equipments' => [
        'name' => 'SubArea Equipments',
        'index_title' => 'Equipments List',
        'new_title' => 'New Equipment',
        'create_title' => 'Create Equipment',
        'edit_title' => 'Edit Equipment',
        'show_title' => 'Show Equipment',
        'inputs' => [
            'equipment_name' => 'Equipment Name',
            'equipment_code' => 'Equipment Code',
            'maintenance_by' => 'Maintenance By',
            'equipment_description' => 'Equipment Description',
        ],
    ],

    'surveys' => [
        'name' => 'Surveys',
        'index_title' => 'Surveys List',
        'new_title' => 'New Survey',
        'create_title' => 'Create Survey',
        'edit_title' => 'Edit Survey',
        'show_title' => 'Show Survey',
        'inputs' => [
            'survey_period_id' => 'Survey Period',
            'sub_category_id' => 'Sub Category',
            'sub_area_id' => 'Sub Area',
            'equipment_id' => 'Equipment',
        ],
    ],

    'survey_initial_tests' => [
        'name' => 'Survey Initial Tests',
        'index_title' => 'InitialTests List',
        'new_title' => 'New Initial test',
        'create_title' => 'Create InitialTest',
        'edit_title' => 'Edit InitialTest',
        'show_title' => 'Show InitialTest',
        'inputs' => [
            'initial_test_tool' => 'Initial Test Tool',
            'initial_test_result' => 'Initial Test Result',
            'initial_test_standard' => 'Initial Test Standard',
            'initial_test_note' => 'Initial Test Note',
        ],
    ],

    'survey_survey_results' => [
        'name' => 'Survey Survey Results',
        'index_title' => 'SurveyResults List',
        'new_title' => 'New Survey result',
        'create_title' => 'Create SurveyResult',
        'edit_title' => 'Edit SurveyResult',
        'show_title' => 'Show SurveyResult',
        'inputs' => [
            'survey_result_condition' => 'Survey Result Condition',
            'survey_result_note' => 'Survey Result Note',
        ],
    ],

    'survey_photos' => [
        'name' => 'Survey Photos',
        'index_title' => 'Photos List',
        'new_title' => 'New Photo',
        'create_title' => 'Create Photo',
        'edit_title' => 'Edit Photo',
        'show_title' => 'Show Photo',
        'inputs' => [
            'photo' => 'Photo',
            'remarks' => 'Remarks',
        ],
    ],

    'survey_settlements' => [
        'name' => 'Survey Settlements',
        'index_title' => 'Settlements List',
        'new_title' => 'New Settlement',
        'create_title' => 'Create Settlement',
        'edit_title' => 'Edit Settlement',
        'show_title' => 'Show Settlement',
        'inputs' => [
            'settlement_condition' => 'Settlement Condition',
            'settlement_note' => 'Settlement Note',
            'settlement_document' => 'Settlement Document',
        ],
    ],

    'survey_settlement_by_business_units' => [
        'name' => 'Survey Settlement By Business Units',
        'index_title' => 'SettlementByBusinessUnits List',
        'new_title' => 'New Settlement by business unit',
        'create_title' => 'Create SettlementByBusinessUnit',
        'edit_title' => 'Edit SettlementByBusinessUnit',
        'show_title' => 'Show SettlementByBusinessUnit',
        'inputs' => [
            'spk_no' => 'SPK No',
            'progress' => 'Progress',
            'photo' => 'Photo',
            'condition' => 'Condition',
            'note' => 'Note',
        ],
    ],

    'sub_area_maintenance_documents' => [
        'name' => 'SubArea Maintenance Documents',
        'index_title' => 'MaintenanceDocuments List',
        'new_title' => 'New Maintenance document',
        'create_title' => 'Create MaintenanceDocument',
        'edit_title' => 'Edit MaintenanceDocument',
        'show_title' => 'Show MaintenanceDocument',
        'inputs' => [
            'document_name' => 'Document Name',
            'document_remarks' => 'Document Remarks',
            'document_file' => 'Document File',
        ],
    ],

    'equipment_maintenance_documents' => [
        'name' => 'Equipment Maintenance Documents',
        'index_title' => 'MaintenanceDocuments List',
        'new_title' => 'New Maintenance document',
        'create_title' => 'Create MaintenanceDocument',
        'edit_title' => 'Edit MaintenanceDocument',
        'show_title' => 'Show MaintenanceDocument',
        'inputs' => [
            'document_name' => 'Document Name',
            'document_remarks' => 'Document Remarks',
            'document_file' => 'Document File',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
