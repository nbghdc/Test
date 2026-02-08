<section>
    <h1>Register Patient</h1>
    <form method="post" action="/patients">
        <div class="grid">
            <label>Name
                <input type="text" name="name" required>
            </label>
            <label>Age
                <input type="number" name="age" required>
            </label>
            <label>Sex
                <select name="sex" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </label>
            <label>Mobile
                <input type="text" name="mobile" required>
            </label>
            <label>Address
                <input type="text" name="address">
            </label>
            <label>History
                <textarea name="history" rows="3"></textarea>
            </label>
        </div>
        <button class="btn primary" type="submit">Save</button>
    </form>
</section>
