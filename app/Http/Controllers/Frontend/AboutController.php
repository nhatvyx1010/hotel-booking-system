<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Testimonial;

class AboutController extends Controller
{
    public function AboutUs(){
        return view('frontend.about.about');
    }

    public function Service(){
        $facilities = Facility::select('facility_name')->distinct()->get();
        return view('frontend.service.service', compact('facilities'));
    }

    public function TermsUs(){
        return view('frontend.term.term');
    }

    public function PrivacyUs(){
        return view('frontend.privacy.privacy');
    }

    public function TestimonialsList()
    {
        $testimonials = Testimonial::all();
        
        return view('frontend.testimonial.testimonial', compact('testimonials'));
    }
}
