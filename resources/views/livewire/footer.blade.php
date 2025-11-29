<div id="footer-wrapper">
    <div class="newsletter-container">
        <div>
            <h2 class="newsletter-title">
                Join our newsletter
            </h2>
            <p class="newsletter-text">
                Be the first to know about our latest updates, exclusive offers, and more.
            </p>
        </div>
        
        <form class="newsletter-form" method="POST" action="{{ route('newsletter.subscribe') }}">
            @csrf <input 
                class="email-input" 
                name="email" 
                placeholder="Enter your email" 
                required 
                type="email"
                value="{{ old('email') }}" />
            <button class="subscribe-button" type="submit">
                Subscribe
            </button>

            
        </form>
        
    </div>
    <footer class="footer-main">
        <div class="footer-grid">
            <div>
                <h3 class="logo-heading">
                    Nail Art Studio
                </h3>
                <div class="social-links">
                    <a aria-label="Facebook" class="social-link" href="#">
                        <i class="fab fa-facebook-f social-icon"></i>
                    </a>
                    <a aria-label="Instagram" class="social-link" href="#">
                        <i class="fab fa-instagram social-icon"></i>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="column-heading">
                    Customer Service
                </h4>
                <ul class="link-list">
                    <li><a class="footer-link" href="#">Booking & Appointments</a></li>
                    <li><a class="footer-link" href="#">Frequently Asked Questions</a></li>
                    <li><a class="footer-link" href="#">Cancellation Policy</a></li>
                    <li><a class="footer-link" href="#">Gift Cards</a></li>
                    <li><a class="footer-link" href="#">My Account</a></li>
                    <li><a class="footer-link" href="#">Payment Options</a></li>
                    <li><a class="footer-link" href="#">Zip</a></li>
                </ul>
            </div>
            <div>
                <h4 class="column-heading">
                    Services
                </h4>
                <ul class="link-list">
                    <li><a class="footer-link" href="#">Nail Art Designs</a></li>
                    <li><a class="footer-link" href="#">Manicure</a></li>
                    <li><a class="footer-link" href="#">Pedicure</a></li>
                    <li><a class="footer-link" href="#">Gel Nails</a></li>
                    <li><a class="footer-link" href="#">Acrylic Nails</a></li>
                    <li><a class="footer-link" href="#">Nail Care Products</a></li>
                </ul>
            </div>
            <div>
                <h4 class="column-heading">
                    About Us
                </h4>
                <ul class="link-list">
                    <li><a class="footer-link" href="#">Our Story</a></li>
                    <li><a class="footer-link" href="#">Contact Us</a></li>
                    <li><a class="footer-link" href="#">Reviews</a></li>
                    <li><a class="footer-link" href="#">Sitemap</a></li>
                </ul>
            </div>
            <div>
                <h4 class="column-heading">
                    Company info
                </h4>
                <div class="company-info-text">
                    <div>
                        <p class="info-label">Address</p>
                        <p>Bandung, Indonesia</p>
                    </div>
                    <div>
                        <p class="info-label">Email</p>
                        <p>support@nailartstudio.com</p>
                    </div>
                    <div>
                        <p class="info-label">Business Number</p>
                        <p>123 456 789</p>
                    </div>
                    <div>
                        <p class="info-label">Company Reviews</p>
                        <div class="review-logos">
                            <img alt="Google star rating with 5 stars" class="review-logo" height="20" src="https://storage.googleapis.com/a1aa/image/849c18c5-0d0a-4934-53d5-277d521e11a7.jpg" width="60"/>
                            <img alt="Product Review logo" class="review-logo" height="20" src="https://storage.googleapis.com/a1aa/image/62aa740b-6dec-41ab-076f-1f3a86b77ca1.jpg" width="80"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-bar">
            <div class="copyright-links">
                <span>© 2025 Nail Art Studio</span>
                <a class="footer-link" href="#">Privacy Policy</a>
                <a class="footer-link" href="#">Terms of Service</a>
                <a class="footer-link" href="#">Security Policy</a>
            </div>
        </div>
    </footer>
</div>