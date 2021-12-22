<?php
$thisyear = date("Y");
$roles = [
  "Organization Setup" => [
    "icon"  => "home",
    "links" => [
      [
        "title" => "Dashboard",
        "url"   => "custom-view/dashboard-mini"
      ],
      [
        "title" => "Settings",
        "url"   => "form-view/organization"
      ],
      [
        "title" => "Role",
        "url"   => "content-view/role"
      ],
    ]
  ],
  "Users" => [
    "icon"  => "user",
    "links" => [
      [
        "title" => "Administrators",
        "url"   => "content-view/users"
      ],
      [
        "title" => "Members",
        "url"  => "level-view/accounts"
      ]
    ]
  ],
  "Business" => [
    "icon"  => "briefcase",
    "links" => [
      [
        "title" => "Coins",
        "url"  => "content-view/added-coins"
      ],
      [
        "title" => "Plans",
        "url"  => "content-view/plans"
      ],
      [
        "title" => "Real Estates",
        "url"  => "content-view/real-estates"
      ],
    ]
  ],

  "Transactions" => [
    "icon"  => "history",
    "links" => [
      [
        "title" => "Deposit Transactions",
        "url"  => "content-view/deposits"
      ],
      [
        "title" => "Withdrawal Transactions",
        "url"  => "content-view/withdrawals"
      ],
      [
        "title" => "Interest History",
        "url"  => "content-view/interests"
      ],
      [
        "title" => "Unpaid Transactions",
        "url"  => "content-view/invoice"
      ]
    ],
  ]
];
