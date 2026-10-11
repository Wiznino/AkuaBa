<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminFundraisingController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\AdminOutreachBroadcastController;
use App\Http\Controllers\EquipmentSponsorshipController;
use App\Http\Controllers\OutreachSubscriptionController;
use App\Http\Controllers\PartnershipInquiryController;
use App\Http\Controllers\VolunteerRegistrationController;
use App\Http\Middleware\EnsureAdmin;
use App\Models\EquipmentSponsorship;
use App\Models\FundraisingProgress;
use App\Models\MediaItem;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'slides' => MediaItem::published()
            ->where('media_type', 'image')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(),
        'resources' => MediaItem::published()
            ->where('media_type', 'document')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(),
        'videos' => MediaItem::published()
            ->where('media_type', 'video')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(3)
            ->get(),
        'fundraisingProgress' => FundraisingProgress::query()->find(1),
        'fundraisingTarget' => FundraisingProgress::TARGET_AMOUNT,
        'hasMediaLibrary' => MediaItem::exists(),
    ]);
})->name('home');

Route::post('/outreach-signup', [OutreachSubscriptionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('outreach.subscribe');

Route::post('/volunteer-signup', [VolunteerRegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('volunteer.register');

Route::post('/partnership-inquiries', [PartnershipInquiryController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('partnership-inquiries.store');

Route::post('/equipment-sponsorships', [EquipmentSponsorshipController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('equipment-sponsorships.store');

Route::view('/sign-up', 'outreach-signup')->name('outreach.signup');

Route::get('/videos', function () {
    return view('videos', [
        'videos' => MediaItem::published()
            ->where('media_type', 'video')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(),
    ]);
})->name('videos.index');

Route::get('/information/{page}', function (string $page) {
    $pages = [
        'about' => [
            'title' => 'About AkuaBa',
            'eyebrow' => 'Our heritage. Our STEM future.',
            'lead' => 'AkuaBa STEM Girls Outreach creates opportunities for girls to explore science, technology, engineering, and mathematics through mentorship and practical learning.',
            'paragraphs' => [
                'AkuaBa is built around a simple belief: every girl deserves the confidence, support, and tools to discover what she can do.',
                'The outreach brings girls together to explore ideas, experiment, design, build, and learn from mentors. Its work is guided by three commitments: inspire curiosity, empower girls, and equip them with practical skills.',
            ],
            'points' => ['Hands-on STEM learning', 'Mentorship and encouragement', 'Opportunities to grow into future leaders and problem-solvers'],
            'outreach_contact' => ['name' => 'Patricia Kwakye-Boateng', 'phone' => '020 749 5972'],
        ],
        'founder' => [
            'title' => 'Meet Our Founder',
            'eyebrow' => 'The founder’s passion',
            'lead' => 'I am passionate about inspiring girls to believe in their potential, explore STEM with confidence, and see education as a pathway to opportunity.',
            'paragraphs' => [
                'Through outreach, mentorship, and hands-on learning, I want young girls to feel seen, capable, and empowered to shape their future.',
            ],
            'founder_credentials' => [
                'Mechanical Engineering Lecturer at Accra Technical University (ATU)',
                'PhD in Mechanical Engineering, University of Johannesburg, South Africa',
                'ASHRAE Student Activist Chair, ASHRAE Ghana Chapter',
            ],
            'points' => [],
            'founder_image' => 'images/akuaba-founder.jpg',
            'founder_image_alt' => 'Portrait of the founder of AkuaBa STEM Girls',
        ],
        'mission' => [
            'title' => 'Our mission',
            'eyebrow' => 'Inspire. Empower. Equip.',
            'lead' => 'AkuaBa STEM Girls inspires, empowers, and equips girls through STEM education, mentorship, and practical learning experiences.',
            'paragraphs' => [
                'We help girls build confidence and discover what is possible in science, technology, engineering, and mathematics.',
                "Through supportive mentors and hands-on activities, girls can develop practical skills and prepare to become tomorrow's leaders, innovators, and changemakers.",
            ],
            'points' => ['Inspire curiosity and big ideas', 'Empower girls through confidence and mentorship', 'Equip learners with practical STEM skills'],
        ],
        'programs' => [
            'title' => 'What we do',
            'eyebrow' => 'Learning with purpose',
            'lead' => 'Girls learn STEM by exploring real ideas, trying things out, and building skills alongside mentors who encourage them to aim high.',
            'paragraphs' => [
                'AkuaBa outreach brings practical learning in science, technology, engineering, and mathematics to girls and their communities.',
                'Activities include exploring scientific ideas, experimenting, designing and building, coding, and solving problems together.',
            ],
            'points' => ['Science discovery and experiments', 'Engineering design and robotics', 'Technology, coding, and creative problem-solving'],
        ],
        'vision' => [
            'title' => 'Our vision',
            'eyebrow' => 'Our heritage. Our STEM future.',
            'lead' => 'We envision a future where every girl has the confidence, opportunity, and support to explore STEM and pursue her ambitions.',
            'paragraphs' => [
                'AkuaBa wants girls to become scientists, engineers, technologists, and problem-solvers who transform their communities and the world.',
                'With innovation, mentorship, and education, we are working toward a future where every girl has room to imagine and the tools to make her ideas real.',
            ],
            'points' => ['Confidence to explore', 'Opportunity to pursue ambitions', 'Support to lead and make change'],
        ],
        'impact' => [
            'title' => 'Our impact',
            'eyebrow' => 'Progress we can stand behind',
            'lead' => 'AkuaBa is preparing to share clear, verified updates about the girls, schools, and communities reached through its outreach.',
            'paragraphs' => [
                'We will publish participation and activity figures here when they have been confirmed by the outreach team.',
            ],
            'points' => [],
            'impact_measures' => ['Girls reached', 'Schools visited', 'STEM workshops held'],
        ],
        'support' => [
            'title' => 'Support the outreach',
            'eyebrow' => 'Help make hands-on STEM possible',
            'lead' => 'AkuaBa is raising GHS 35,780 for outreach equipment that will help girls learn through practical STEM activities.',
            'paragraphs' => [
                'Contribute any amount or donate equipment in kind. Purchases will begin as funds are received.',
                'Before purchasing equipment, contact Patricia Kwakye-Boateng to confirm the recommended specifications.',
            ],
            'points' => EquipmentSponsorship::EQUIPMENT_OPTIONS,
            'mobile_money' => ['number' => '020 749 5972', 'name' => 'Patricia Kwakye-Boateng', 'reference' => 'AkuaBa'],
            'support_actions' => [
                ['title' => 'Donate', 'description' => 'Contribute any amount by Mobile Money. Confirm the payment details before sending.', 'label' => 'View payment details', 'page' => 'donate'],
                ['title' => 'Sponsor equipment', 'description' => 'Fund a full item or contribute toward the projector, generator, PA system, and outreach supplies.', 'label' => 'See equipment list', 'page' => 'sponsor-equipment'],
                ['title' => 'Volunteer', 'description' => 'Offer your time, STEM knowledge, or mentorship to support girls during outreach activities.', 'label' => 'Explore volunteering', 'page' => 'volunteer'],
                ['title' => 'Partner with us', 'description' => 'Schools, organizations, and community partners can contact AkuaBa to discuss working together.', 'label' => 'Explore partnership', 'page' => 'partner'],
            ],
        ],
        'donate' => [
            'title' => 'Donate to AkuaBa',
            'eyebrow' => 'Support the outreach',
            'lead' => 'Contribute any amount toward hands-on STEM outreach for girls.',
            'paragraphs' => [
                'AkuaBa is raising GHS 35,780 for outreach equipment. Please confirm the payment details with AkuaBa before sending a contribution.',
            ],
            'points' => [],
            'mobile_money' => ['number' => '020 749 5972', 'name' => 'Patricia Kwakye-Boateng', 'reference' => 'AkuaBa'],
            'outreach_contact' => ['name' => 'Patricia Kwakye-Boateng', 'phone' => '020 749 5972'],
        ],
        'sponsor-equipment' => [
            'title' => 'Sponsor equipment',
            'eyebrow' => 'Help equip the outreach',
            'lead' => 'Sponsor a complete item or contribute toward equipment that supports practical STEM learning.',
            'paragraphs' => [
                'AkuaBa is raising GHS 35,780 for the outreach equipment below. Please contact us to confirm recommended specifications before purchasing equipment.',
            ],
            'points' => EquipmentSponsorship::EQUIPMENT_OPTIONS,
            'outreach_contact' => ['name' => 'Patricia Kwakye-Boateng', 'phone' => '020 749 5972'],
        ],
        'volunteer' => [
            'title' => 'Volunteer with AkuaBa',
            'eyebrow' => 'Share your time and skills',
            'lead' => 'Support girls during outreach by sharing your time, STEM knowledge, practical skills, or mentorship.',
            'paragraphs' => [
                'AkuaBa welcomes volunteers who want to contribute to upcoming outreach activities.',
            ],
            'points' => ['Share STEM knowledge and practical skills', 'Encourage girls through mentorship', 'Support hands-on outreach activities'],
            'outreach_contact' => ['name' => 'Patricia Kwakye-Boateng', 'phone' => '020 749 5972'],
        ],
        'partner' => [
            'title' => 'Partner with AkuaBa',
            'eyebrow' => 'Work together for girls in STEM',
            'lead' => 'AkuaBa welcomes conversations with schools, organizations, and community partners interested in supporting STEM outreach.',
            'paragraphs' => [
                'Schools, organizations, and community partners can get in touch with AkuaBa about working together.',
            ],
            'points' => ['Schools', 'Organizations', 'Community partners'],
            'outreach_contact' => ['name' => 'Patricia Kwakye-Boateng', 'phone' => '020 749 5972'],
        ],
    ];

    abort_unless(array_key_exists($page, $pages), 404);

    return view('information', ['page' => $pages[$page], 'pageSlug' => $page]);
})->name('information.show');

Route::get('/admin/setup', [AdminAuthController::class, 'setup'])->name('admin.setup');
Route::post('/admin/setup', [AdminAuthController::class, 'storeAdmin'])->name('admin.setup.store');
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->middleware(EnsureAdmin::class)->name('admin.logout');

Route::middleware(EnsureAdmin::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminMediaController::class, 'index'])->name('dashboard');
    Route::patch('/fundraising-progress', [AdminFundraisingController::class, 'update'])->name('fundraising-progress.update');
    Route::post('/outreach-broadcasts', [AdminOutreachBroadcastController::class, 'store'])->name('outreach.broadcast');
    Route::delete('/volunteers/{volunteerRegistration}', [VolunteerRegistrationController::class, 'destroy'])->name('volunteers.destroy');
    Route::delete('/partnership-inquiries/{partnershipInquiry}', [PartnershipInquiryController::class, 'destroy'])->name('partnership-inquiries.destroy');
    Route::delete('/equipment-sponsorships/{equipmentSponsorship}', [EquipmentSponsorshipController::class, 'destroy'])->name('equipment-sponsorships.destroy');
    Route::post('/media', [AdminMediaController::class, 'store'])->name('media.store');
    Route::patch('/media/{mediaItem}', [AdminMediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{mediaItem}', [AdminMediaController::class, 'destroy'])->name('media.destroy');
});
