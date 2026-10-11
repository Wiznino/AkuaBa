<?php

namespace Tests\Feature;

use Tests\TestCase;

class SupportActionPagesTest extends TestCase
{
    public function test_support_cards_link_to_their_dedicated_pages(): void
    {
        $response = $this->get(route('information.show', 'support'));

        $response->assertOk();

        foreach (['donate', 'sponsor-equipment', 'volunteer', 'partner'] as $page) {
            $response->assertSee('href="'.route('information.show', $page).'"', false);
        }
    }

    public function test_information_pages_have_a_previous_page_link_with_home_fallback(): void
    {
        $response = $this->get(route('information.show', 'donate'));

        $response->assertOk()
            ->assertSee('href="'.route('home').'" data-history-back', false)
            ->assertSee('window.history.back()', false);
    }

    public function test_information_pages_use_the_shared_mobile_navigation(): void
    {
        $response = $this->get(route('information.show', 'donate'));

        $response->assertOk()
            ->assertSee('aria-controls="hamburger-navigation"', false)
            ->assertSee('id="primary-navigation"', false)
            ->assertSee('id="hamburger-navigation"', false)
            ->assertSee('aria-label="Expanded navigation"', false)
            ->assertSee('Donate')
            ->assertDontSee('Support us')
            ->assertSee('Email updates')
            ->assertSee('Admin sign in')
            ->assertDontSee('information-nav');
    }

    public function test_donation_page_shows_mobile_money_details(): void
    {
        $response = $this->get(route('information.show', 'donate'));

        $response->assertOk()
            ->assertSee('020 749 5972')
            ->assertSee('Patricia Kwakye-Boateng')
            ->assertDontSee('Call to confirm donation details')
            ->assertDontSee('Call to discuss');
    }

    public function test_equipment_sponsorship_page_shows_fundraising_items(): void
    {
        $response = $this->get(route('information.show', 'sponsor-equipment'));

        $response->assertOk()
            ->assertSee('Projector and screen')
            ->assertSee('3.0 kW inverter generator')
            ->assertSee('020 749 5972')
            ->assertDontSee('Call to discuss');
    }

    public function test_volunteer_page_shows_ways_to_help_and_contact_details(): void
    {
        $response = $this->get(route('information.show', 'volunteer'));

        $response->assertOk()
            ->assertSee('Share STEM knowledge and practical skills')
            ->assertSee('020 749 5972')
            ->assertDontSee('Call to discuss');
    }

    public function test_partner_page_shows_partner_types_and_contact_details(): void
    {
        $response = $this->get(route('information.show', 'partner'));

        $response->assertOk()
            ->assertSee('Community partners')
            ->assertSee('020 749 5972')
            ->assertDontSee('Call to discuss');
    }
}
