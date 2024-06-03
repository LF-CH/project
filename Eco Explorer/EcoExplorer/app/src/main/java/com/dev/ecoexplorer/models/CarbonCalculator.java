package com.dev.ecoexplorer.models;

public class CarbonCalculator {

    // Method to calculate carbon emission rate based on vehicle type
    public static double calculateCarbonEmissionRate(double distance, double emissionFactor, String vehicleType) {
        double vehicleFactor = getVehicleFactor(vehicleType);
        return distance * emissionFactor * vehicleFactor;
    }

    // Method to get vehicle factor based on vehicle type
    private static double getVehicleFactor(String vehicleType) {
        switch (vehicleType) {
            case "car":
                return 1.0; // Standard emission factor for cars
            case "bus":
                return 1.5; // Example: Higher emission factor for buses compared to cars
            case "bike":
                return 0.5; // Example: Lower emission factor for bikes compared to cars
            default:
                return 1.0; // Default to standard emission factor
        }
    }
}
